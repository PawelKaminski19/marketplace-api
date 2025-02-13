<?php

namespace App\Http\Controllers\Api\Login\UsersLogin;

use App\Http\Controllers\Api\Login\AuthController;
use App\Http\Requests\UsersRequests\ChooseSpecificAccountRequest;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInWithAccountsResource;
use App\Models\User;
use App\Packages\AccountType;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DomainServices\DomainService;
use App\Http\Resources\UsersRolesAndPermissions\UserMeAllDataResource;
use App\Repositories\ClientRepository;
use App\Exceptions\NoPermissionException;
use App\Exceptions\BadRequestException;


class CustomerLoginController extends AuthController
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
            ClientRepository $clientRepository)
    {
       parent::__construct($request, $domainService, $usersAccountService, $userLoggedInResource, $userLoggedInWithAccountsResource, $userResource, $clientRepository);
      
    }

   
    /**
     * Generic login endpoint
     *
     * For Users with a single account it should return a redirection to the dashobard (an object with the single account + client entity)
     * For Users with multiple accounts it should return a list of accounts - each account should have a client assigned
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
        //if not, then we need to filter out the customers from other domains
        $customers = $this->soDomain ? auth()->user()->customers : auth()->user()->customers->filter(function ($value, $key) {
            return $this->domain->client_id === $value->client->id;
        });
        //end of filtering out customers from other domains

        if ($customers->count() > 0) {
            //logging in an default affiliate...
            $this->usersAccountService->setLoggedInAccount(auth()->user(), AccountType::customer(), $customers->first()->id);
        }
        //... and check if logged in user have a software owner rights to the client found earlier
        if ($customers->count() == 1) {
            //retrieveing a user data
            $this->userLoggedInResource->setData(auth()->user()->fresh(), $this->respondWithToken($token));
            return $this->userLoggedInResource;
        }
        if ($customers->count() > 1) {
            //there is more than one affiliate assigned to that client, let's create a list of clients
            $accounts[AccountType::customer()] = $customers;
            $this->userLoggedInWithAccountsResource->setData(array_merge($this->respondWithToken($token), ["accounts" => $accounts]));
            return $this->userLoggedInWithAccountsResource;
        }
        auth()->logout();

        //default response
        return response()->json(['error' => 'Wrong Client'], 401);
    }

}