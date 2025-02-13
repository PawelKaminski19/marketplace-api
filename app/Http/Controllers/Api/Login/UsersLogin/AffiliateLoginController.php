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

class AffiliateLoginController extends AuthController
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
     * Login endpoint for Affiliates
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        //try to login...
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (empty($this->domain)) {
            return response()->json(['error' => 'Please provide the correct domain name'], 401);
        }

        //now we're checking if the request came from the "Software Owner Domain (MiddlewareCheck)"
        //if not, then we need to filter out the affiliates from other domains
        $affiliates = $this->soDomain ? auth()->user()->affiliates : auth()->user()->affiliates->filter(function ($value, $key) {
            return in_array($this->domain->client_id, $value->clients->pluck('id')->toArray());
        });
        //end of filtering out affiliates from other domains

        if ($affiliates->count() > 0) {
            //logging in an default affiliate...
            $this->usersAccountService->setLoggedInAccount(auth()->user(), AccountType::affiliate(), $affiliates->first()->id);
        }
           //... and check if there is only one affiliate account matching the criteria
        if ($affiliates->count() == 1) {
            //retrieveing a user data
            $this->userLoggedInResource->setData(auth()->user()->fresh(), $this->respondWithToken($token));
            return $this->userLoggedInResource;
        }
        if ($affiliates->count() > 1) {
            //there is more than one affiliate assigned to that client, let's create a list of clients
            $accounts[AccountType::affiliate()] = $affiliates;
            $this->userLoggedInWithAccountsResource->setData(array_merge($this->respondWithToken($token), ["accounts" => $accounts]));
            return $this->userLoggedInWithAccountsResource;
        }
        auth()->logout();

        //default response
        return response()->json(['error' => 'Wrong Client'], 401);
    }

}
