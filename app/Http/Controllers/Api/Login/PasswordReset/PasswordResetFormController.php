<?php

namespace App\Http\Controllers\Api\Login\PasswordReset;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Services\TokenServices\GenerateTokenService;
use App\Notifications\SendLoginLinkMailNotification;
use App\Services\UserServices\UsersAccountService;
use App\Packages\TokenStatuses;
use App\Packages\AccountType;
use App\Services\UserServices\UsersService;
use App\Http\Resources\UsersRolesAndPermissions\UserLoggedInResource;
use App\Services\Twilio\Verification;

class PasswordResetFormController extends BaseApiController
{
    /**
     * Create a new CustomerSendLinkController instance.
     * @param GenerateTokenService $generateTokenService
     * @param UsersService $usersService
     * @param UsersAccountService $usersAccountService
     * @param UserLoggedInResource $userLoggedInResource
     * @return void
     */
    public function __construct(Request $request,
        GenerateTokenService $generateTokenService,
        UsersService $usersService,
        UsersAccountService $usersAccountService,
        UserLoggedInResource $userLoggedInResource,
        Verification $twilioService) {
        parent::__construct();
        $this->generateTokenService = $generateTokenService;
        $this->usersService = $usersService;
        $this->usersAccountService = $usersAccountService;
        $this->userLoggedInResource = $userLoggedInResource;
        $this->twilioService = $twilioService;
    }

    /**
     * 3rd step of reset password feature -  sendlinkg endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function form(Request $request, string $hash)
    {   
        $tokenRepo = app()->make(\App\Repositories\TokenRepository::class);
        $token = $tokenRepo->check('verify', \App\Models\User::class, $hash);

        $message = null;

        if ($token == TokenStatuses::notFound()) {
            return response()->json(["message" => __('Token not found.')]);
        } elseif ($token == TokenStatuses::used()) {
            return response()->json(["message" => __('Token used.')]);
        } elseif ($token == TokenStatuses::expired()) {
            return response()->json(["message" => __('Token expired.')]);
        } else {
            $user = $this->usersService->find($token['model_id']);

            if (!empty($token['hash'])) {
                if ($token['hash'] == $hash) {
                    $verificationCode = $request->input('verificationCode');

                    $verification = $this->twilioService->checkVerification($user->phone, $verificationCode);

                    if ($verification->isValid()) {
                        return response()->json(["message" => "Token verified."], 200);
                    }
                }
            }
            return response()->json(["message" => "Wrong token or user."], 400);
        }
    }
}

