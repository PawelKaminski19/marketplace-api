<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\UsersRequests\ChooseSpecificAccountRequest;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInWithAccountsResource;
use App\Http\Resources\UsersRolesAndPermissions\UserMeAllDataResource;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Services\DomainServices\DomainService;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChooseAccountController extends BaseApiController
{
    /**
     * @var UsersAccountService
     */
    protected $usersAccountService;

    /**
     * @var userLoggedInResource
     */
    protected $userLoggedInResource;

    /**
     * @var accountType
     */
    protected $accountType;

    /**
     * @var accountId
     */
    protected $accountId;

    /**
     * Create a new AuthController instance.
     * @param UsersAccountService $usersAccountService
     * @param userLoggedInResource $userLoggedInResource
     * @return void
     */
    public function __construct(Request $request, UsersAccountService $usersAccountService, UserLoggedInResource $userLoggedInResource)
    {
        parent::__construct();
        $this->usersAccountService = $usersAccountService;
        $this->userLoggedInResource = $userLoggedInResource;
        $this->account = $request->get("account_type",null);
        $this->accountId = $request->get("account_id",null);
    }

      /**
     * Choose the account from the list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function chooseAccount(ChooseSpecificAccountRequest $request)
    {
        //checking if given account Type is a part of all account types list
        //checking if user can log to given account
        if ($this->usersAccountService->chooseAccount(auth()->user(), $this->account, $this->accountId)) {
            $this->userLoggedInResource->setData(auth()->user()->fresh(), []);
            return $this->userLoggedInResource;
        }
        return response()->json(['message' => 'Account not found']);
    }   

}
