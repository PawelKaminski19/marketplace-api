<?php

namespace App\Http\Controllers\Api\Login\UsersLogin;

use App\Http\Controllers\Api\Login\AuthController;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInWithAccountsResource;
use App\Http\Resources\UsersRolesAndPermissions\UserMeAllDataResource;
use App\Models\User;
use App\Packages\AccountType;
use App\Repositories\ClientRepository;
use App\Services\DomainServices\DomainService;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsEmployeeLoginController extends AuthController
{
    /**
     * Create a new AffiliateLoginController instance.
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

    }
    /**
    * Performs actual login with two cases - secure login (by slug), or general login by credentials
    *
    * @param Client $client
    * @param int $securePathEnabled
    * @return \Illuminate\Http\JsonResponse
    */
    private function performLogin($client, $securePathEnabled = 0)
    {

        if ($client) {
            $credentials = request(['email', 'password']);

            //try to login...
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //now we're checking if the request came from the "Software Owner Domain (MiddlewareCheck)"
            //if not, then we need to filter out the employees from other domains
            $employees = $this->soDomain ? auth()->user()->employees : auth()->user()->employees->filter(function ($value, $key) {
                return $value->client->id == $this->domain->client_id;
            });
            //end of filtering out employees from other domains

             //second filtering to choose the client from the url
             $employees = !$securePathEnabled ? $employees : $employees->filter(function ($value, $key) use ($client) {
                return $value->client->id == $client->id;
            });
            //end of filtering out employees from other domains

            //3rd filltering of the secure_path
            $employees = $employees->filter(function ($value, $key) use ($securePathEnabled) {
                return $value->client->secure_path === $securePathEnabled;
            });

            if ($employees->count() > 0) {
                //logging in an default employee...
                $this->usersAccountService->setLoggedInAccount(auth()->user()->fresh(), AccountType::employee(), $employees->first()->id);
            }
                //... and check if there is only one employee account matching the criteria
            if ($employees->count() == 1) {
                //retrieveing a user data
                $this->userLoggedInResource->setData(auth()->user()->fresh(), $this->respondWithToken($token));
                return $this->userLoggedInResource;
            }
            if ($employees->count() > 1) {
                //there is more than one employees assigned to that client, let's create a list of clients
                $accounts[AccountType::employee()] = $employees;
                $this->userLoggedInWithAccountsResource->setData(array_merge($this->respondWithToken($token), ["accounts" => $accounts]));
                return $this->userLoggedInWithAccountsResource;
            }
            if (auth()->user()->fresh()) {
                auth()->logout();
            }
        }
        //default response
        return response()->json(['message' => 'Account not found'], 401);
    }
    /**
     * Login endpoint for employees
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (empty($this->domain)) {
            return response()->json(['error' => 'Please provide the correct domain name'], 401);
        }
        $client = $this->clientRepository->find($this->domain->client_id, false);
        return $this->performLogin($client, 0);
    }

    /**
     * Login endpoint for a employee
     * The difference is that, here we need to find the URL provided
     * so Employee can login only to ONE Client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginByUrl(Request $request)
    {
        //firstly let's grab the clients name from the URL and try to find it in the database
        $client = $this->clientRepository->findBySlug($request['slug']);
        return $this->performLogin($client, 1);
    }
}
