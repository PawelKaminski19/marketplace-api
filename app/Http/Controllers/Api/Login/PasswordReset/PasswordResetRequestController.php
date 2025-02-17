<?php

namespace App\Http\Controllers\Api\Login\PasswordReset;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Services\TokenServices\GenerateTokenService;
use App\Notifications\PasswordResetNotification;
use App\Services\UserServices\UsersAccountService;
use App\Packages\TokenStatuses;
use App\Packages\AccountType;
use App\Services\CustomerServices\CustomerService;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;

class PasswordResetRequestController extends BaseApiController
{
    /**
     * Create a new CustomerSendLinkController instance.
     * @param GenerateTokenService $generateTokenService
     * @param CustomerService $customerService
     * @param UsersAccountService $usersAccountService
     * @param UserLoggedInResource $userLoggedInResource
     * @return void
     */
    public function __construct(Request $request,
        GenerateTokenService $generateTokenService,
        CustomerService $customerService,
        UsersAccountService $usersAccountService,
        UserLoggedInResource $userLoggedInResource) {
        parent::__construct();
        $this->generateTokenService = $generateTokenService;
        $this->customerService = $customerService;
        $this->usersAccountService = $usersAccountService;
        $this->userLoggedInResource = $userLoggedInResource;
    }

    /**
     * 1st step of reset password feature - sending email  for password reseting
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(string $email, int $websiteId = null)
    {   
        $user = $this->customerService->findByEmailAndWebsite($email, $websiteId ? $websiteId : $this->domain->website_id);
        if ($user) {
            $token = $this->generateTokenService->generate('verify', \App\Models\User::class, $user->id, 6, 30, 'password_reset');
        
            $user->notify(new PasswordResetNotification([
                "fullUsername" => $user->name,
                "hash" => $token['hash'],
                "expiration_minutes" => $token['expiration_minutes'],
                "domain" => $this->domain->url
            ]));

                return response()->json($token);
        }
        return response()->json(uniqid());
    }
}

