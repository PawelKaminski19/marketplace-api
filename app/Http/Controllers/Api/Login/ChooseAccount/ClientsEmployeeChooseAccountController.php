<?php

namespace App\Http\Controllers\Api\Login\ChooseAccount;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\UsersRequests\ChooseSpecificAccountRequest;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Models\User;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Login\ChooseAccountController;
use App\Packages\AccountType;

class ClientsEmployeeChooseAccountController extends ChooseAccountController
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
     * Create a new AuthController instance.
     * @param Request $request
     * @param UsersAccountService $usersAccountService
     * @param userLoggedInResource $userLoggedInResource
     * @return void
     */
    public function __construct(ChooseSpecificAccountRequest $request, UsersAccountService $usersAccountService, UserLoggedInResource $userLoggedInResource)
    {
        parent::__construct($request, $usersAccountService, $userLoggedInResource);
        $this->account = AccountType::employee();
    }

}
