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
use App\Http\Requests\PasswordRequests\UpdatePasswordRequest;

class PasswordUpdateController extends BaseApiController
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
        UserLoggedInResource $userLoggedInResource) {
        parent::__construct();
        $this->generateTokenService = $generateTokenService;
        $this->usersService = $usersService;
        $this->usersAccountService = $usersAccountService;
        $this->userLoggedInResource = $userLoggedInResource;
    }

    /**
     * 4th step of reset password feature - sendlinkg endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePasswordRequest $request, string $hash)
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
                    if ($this->usersService->update($user->id, ['password' => $request->input('password')])) {
                        $tokenRepo->updateTokenUsage($hash);
                    }
                    return response()->json(["message" => "Password changed."]);
                }
            }
            return response()->json(["message" => "Wrong token or user."], 400);
        }
    }
}

