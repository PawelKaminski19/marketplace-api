<?php

namespace App\Http\Controllers\Api\Login\LoginByLink\Customer;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Packages\AccountType;
use App\Packages\TokenStatuses;
use App\Services\CustomerServices\CustomerService;
use App\Services\Twilio\Verification;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;

class LoginByLinkController extends BaseApiController
{
    /**
     * Create a new CustomerSendLinkController instance.
     * @param CustomerService $customerService
     * @param UsersAccountService $usersAccountService
     * @param UserLoggedInResource $userLoggedInResource
     * @param Verification $twilioService
     * @return void
     */
    public function __construct(
        CustomerService $customerService,
        UsersAccountService $usersAccountService,
        UserLoggedInResource $userLoggedInResource,
        Verification $twilioService) {
        parent::__construct();
        $this->customerService = $customerService;
        $this->usersAccountService = $usersAccountService;
        $this->userLoggedInResource = $userLoggedInResource;
        $this->twilioService = $twilioService;
    }

    /**
     * sendlinkg endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, string $hash)
    {
        $tokenRepo = app()->make(\App\Repositories\TokenRepository::class);
        $token = $tokenRepo->check('verify', \App\Models\Customer::class, $hash);

        $message = null;

        if ($token == TokenStatuses::notFound()) {
            return response()->json(["message" => __('Token not found.')]);
        } elseif ($token == TokenStatuses::used()) {
            return response()->json(["message" => __('Token used.')]);
        } elseif ($token == TokenStatuses::expired()) {
            return response()->json(["message" => __('Token expired.')]);
        } else {
            $customer = $this->customerService->find($token['model_id']);

            if (!empty($token['hash'])) {
                if ($token['hash'] == $hash) {
                    $verificationCode = $request->input('verificationCode');

                    $verification = $this->twilioService->checkVerification($customer->phone, $verificationCode);

                    if ($verification->isValid()) {
                        $tokenRepo->updateTokenUsage($hash);
                        $token = auth()->login($customer->users->first());

                        $this->usersAccountService->setLoggedInAccount(auth()->user()->fresh(), AccountType::customer(), $customer->users->first()->id);

                        $this->userLoggedInResource->setData(
                            auth()->user()->fresh(),
                            [
                                'logged_in_account' => ['customer' => auth()->user()->toArray()],
                                'access_token' => $token,
                                'token_type' => 'bearer',
                                'expires_in' => auth()->factory()->getTTL() * 60,
                            ]
                        );
                        return $this->userLoggedInResource;
                    }
                }
            }
            return response()->json(["message" => "Wrong token or user."], 400);
        }

    }
}
