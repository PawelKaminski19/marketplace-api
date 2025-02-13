<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInWithAccountsResource;
use App\Http\Resources\UsersRolesAndPermissions\UserMeAllDataResource;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Services\DomainServices\DomainService;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseApiController
{
    /** @var DomainService */
    protected $domainService;

    /** @var UsersAccountService */
    protected $usersAccountService;

    /** @var userLoggedInResource */
    protected $userLoggedInResource;

    /** @var UserLoggedInWithAccountsResource */
    protected $userLoggedInWithAccountsResource;

    /** @var UserMeResource */
    protected $userResource;

    /** @var ClientRepository */
    protected $clientRepository;

    /**
     * Create a new AuthController instance.
     * @param DomainService $domainService
     * @param UsersAccountService $usersAccountService
     * @param userLoggedInResource $userLoggedInResource
     * @param UserLoggedInWithAccountsResource $userLoggedInWithAccountsResource
     * @param UserMeResource $userResource
     * @param ClientRepository $clientRepository
     * @return void
     */
    public function __construct(Request $request, DomainService $domainService, UsersAccountService $usersAccountService, UserLoggedInResource $userLoggedInResource, UserLoggedInWithAccountsResource $userLoggedInWithAccountsResource, UserMeAllDataResource $userResource, ClientRepository $clientRepository)
    {
        parent::__construct();
        $this->usersAccountService = $usersAccountService;
        $this->userLoggedInResource = $userLoggedInResource;
        $this->userLoggedInWithAccountsResource = $userLoggedInWithAccountsResource;
        $this->clientRepository = $clientRepository;
        $this->userResource = $userResource;
        $this->domainService = $domainService;
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

        //let's try to log in
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        //let's get the default account - from the top of hierarchy (but without softwareowner!, for softwareowners we have another login endpoint!)
        //let's get the list of accounts assigned and available for that user
        try {
            $defaultAccount = $this->usersAccountService->getDefaultLoggedInAccountByHierarchy(auth()->user(), false);
            $accounts = $this->usersAccountService->getAccountsByUser(auth()->user());

            //let's set the default account as a logged in
            $this->usersAccountService->setDefaultLoggedInAccountByHierarchy(auth()->user(), $defaultAccount);
        } catch (\Throwable $ex) {
            return response()->json([
                'error' => $ex->getMessage(),
            ]);
        }

        //softwareowner shouldn't be visible on the list!
        //for softwareowners we have another login endpoint!
        if (isset($accounts['softwareowner'])) {
            unset($accounts['softwareowner']);
        }
        //let's check how many accounts are assigned to this account (once again, do not include the softwareowners!)
        if ($this->usersAccountService->getNumberOfAccountsAssignedToUser(auth()->user()->fresh(), false) == 1) {
            //if a single account then redirect to dashboard - return just a one entity
            $this->userLoggedInResource->setData(auth()->user()->fresh(), $this->respondWithToken($token));
        } else {
            //for many accounts return a list
            $this->userLoggedInWithAccountsResource->setData(array_merge($this->respondWithToken($token), ["accounts" => $accounts]));
            return $this->userLoggedInWithAccountsResource;
        }
        return $this->userLoggedInResource;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $this->userResource->setData(auth()->user());
        $this->userResource->setIncludePossibleAccounts(true);
        return $this->userResource;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}
