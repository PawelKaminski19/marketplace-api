<?php

namespace App\Http\Controllers\Api\Login\UsersLogin;

use App\Http\Controllers\Api\Login\AuthController;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInWithAccountsResource;
use App\Http\Resources\UsersRolesAndPermissions\UserMeAllDataResource;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Services\DomainServices\DomainService;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Packages\AccountType;

class SoftwareOwnerLoginController extends AuthController
{
   
    /**
     * Create a new SoftwareOwnerLoginController instance.
     * @param DomainService $domainService
     * @param UsersAccountService $usersAccountService
     * @param userLoggedInResource $userLoggedInResource
     * @param UserLoggedInWithAccountsResource $userLoggedInWithAccountsResource
     * @param UserMeResource $userResource
     * @param ClientRepository $clientRepository
     * @return void
     */
    public function __construct(Request $request,
        DomainService $domainService,
        UsersAccountService $usersAccountService,
        UserLoggedInResource $userLoggedInResource,
        UserLoggedInWithAccountsResource $userLoggedInWithAccountsResource,
        UserMeAllDataResource $userResource,
        ClientRepository $clientRepository) {
        parent::__construct($request, $domainService, $usersAccountService, $userLoggedInResource, $userLoggedInWithAccountsResource, $userResource, $clientRepository);
        $this->request = $request;
    }

    /**
     * Login endpoint for a software owner
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($slug = null)
    {
        //firstly let's grab the clients name from the URL and try to find it in the database
        $client = $this->clientRepository->findBySlug($slug);

        //if client exists
        if ($client) {
            $credentials = request(['email', 'password']);

            //try to login...
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if (empty($this->domain)) {
                return response()->json(['error' => 'Please provide the correct domain name'], 401);
            }

            //... and check if logged in user have a software owner rights to the client found earlier
            // user should have a softwareowner assigned, that has a client with the id equals to the id found by slug AND the source of the domain client id should also be equal to this ID
            if (isset(auth()->user()->softwareowner->client) && auth()->user()->softwareowner->client->id == $client->id && $this->domain->client_id == $client->id) {
                //logging in a software owner...
                $this->usersAccountService->setLoggedInAccount(auth()->user()->fresh(), AccountType::softwareowner(), auth()->user()->softwareowner->id);
                //retrieveing a user data
                $this->userLoggedInResource->setData(auth()->user()->fresh(), $this->respondWithToken($token));
                return $this->userLoggedInResource;
            }

            //now we're checking if the request came from the "Software Owner Domain (MiddlewareCheck)"
            //if not, then we need to filter out the employees from other domains
            $employees = auth()->user()->employees->filter(function ($value, $key) {
                return $value->client->id == $this->domain->client_id;
            });
            //end of filtering out employees from other domains

            if ($employees->count() > 0) {
                //logging in an default employee...
                $this->usersAccountService->setLoggedInAccount(auth()->user()->fresh(), 'employee', $employees->first()->id);
                $this->userLoggedInResource->setData(auth()->user()->fresh(), $this->respondWithToken($token));
                return $this->userLoggedInResource;
            }
            //if a SO has no rights to this client, let's logout him
            auth()->logout();
        }
        //default response
        return response()->json(['error' => 'Wrong Client'], 401);
    }

}
