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

class PasswordResetCodeController extends BaseApiController
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
     * 2nd step of reset password feature - sending a request for verification (starting verification)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function code(string $hash)
    {     
        $tokenRepo = app()->make('App\Repositories\TokenRepository');
        $token = $tokenRepo->check('verify', 'App\Models\User', $hash);
       
        $message = null;

        if ($token == TokenStatuses::notFound()) {
            return response()->json(["message" => __('Token not found.')],400);
        } elseif ($token == TokenStatuses::used()) {
            return response()->json(["message" => __('Token used.')],400);
        } elseif ($token == TokenStatuses::expired()) {
            return response()->json(["message" => __('Token expired.')],400);
        } else {
            $user = $this->usersService->find($token['model_id']);
            
            if (!empty($token['hash'])) {
                if ($token['hash'] == $hash) {
                    
                    $channel = 'sms';
                    $verify = $this->twilioService->startVerification($user->phone, $channel);
            
                    if ($verify->isValid()) {
                        return response()->json(["message" => __('token.verified_and_sent')]);
                    } else {
                        return response()->json(["message" => "Token not verified. Access Denied."],400);
                    }
                }
            }
            return response()->json(["message" => "Wrong token or user."],400);
        }
    }
}

