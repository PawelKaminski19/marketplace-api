<?php

namespace App\Http\Controllers\Api\Login\LoginByLink\Customer;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Services\TokenServices\GenerateTokenService;
use App\Notifications\SendLoginLinkMailNotification;
use App\Services\UserServices\UsersAccountService;
use App\Packages\TokenStatuses;
use App\Packages\AccountType;
use App\Services\CustomerServices\CustomerService;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;

class SendLinkController extends BaseApiController
{
    /**
     * Create a new CustomerSendLinkController instance.
     * @param GenerateTokenService $generateTokenService
     * @param CustomerService $customerService
     * @param UserLoggedInResource $userLoggedInResource
     * @return void
     */
    public function __construct(
        GenerateTokenService $generateTokenService,
        CustomerService $customerService,
        UserLoggedInResource $userLoggedInResource) {
        parent::__construct();
        $this->generateTokenService = $generateTokenService;
        $this->customerService = $customerService;
        $this->userLoggedInResource = $userLoggedInResource;
    }

    /**
     * sendlinkg endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(string $email, int $websiteId)
    {   
       
        $user = $this->customerService->findByEmailAndWebsite($email, $websiteId ? $websiteId : $this->domain->website_id);
        if ($user) {
            $customer = $user->customers->where('website_id', $websiteId)->first();

            $token = $this->generateTokenService->generate('verify', \App\Models\Customer::class, $customer->id, 6, 30, 'verify_login');
        
            $user->notify(new SendLoginLinkMailNotification([
                "fullUsername" => $customer->firstname . " " . $customer->lastname,
                "hash" => $token['hash'],
                "expiration_minutes" => $token['expiration_minutes'],
                "domain" => $this->domain->url
            ]));

            return response()->json($token);
        }
        //default response
        return response()->json(['error' => 'Wrong Client'], 401);
    }
}

