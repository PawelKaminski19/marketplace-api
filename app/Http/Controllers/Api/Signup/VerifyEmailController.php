<?php
namespace App\Http\Controllers\Api\Signup;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\VerifyEmailRequest;
use App\Http\Resources\GuestResources\GuestResource;
use App\Models\Guest;
use App\Packages\TokenStatuses;
use App\Services\DomainServices\DomainService;
use App\Services\SignupServices\GuestService;
use Illuminate\Http\Request;

class VerifyEmailController extends BaseApiController
{
    /**
     * VerifyEmailController constructor.
     * @param DomainService $domainService
     * @param GuestService guestService
     * @param GuestResource $guestResource
     */
    public function __construct(
        DomainService $domainService,
        GuestService $guestService,
        GuestResource $guestResource
    ) {
        $this->domainService = $domainService;
        $this->guestService = $guestService;
        $this->guestResource = $guestResource;
    }

    /**
     * Verify guests email by token
     *
     * @param VerifyEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function verify(VerifyEmailRequest $request)
    {
        $queryToken = $request->input('token');
        $uuid = $request->input('uuid', null);

        if ($uuid) {
            $guest = $this->guestService->findByUuid($uuid);
        }

        if ($guest) {
            $tokenRepo = app()->make(\App\Repositories\TokenRepository::class);
            $token = $tokenRepo->check('verify_email', \App\Models\Guest::class, $request->input('hash'));

            $message = null;

            if ($token == TokenStatuses::notFound()) {
                return response()->json(["message" => __('Token not found.')],400);
            } elseif ($token == TokenStatuses::used()) {
                return response()->json(["message" => __('Token used.')],400);
            } elseif ($token == TokenStatuses::expired()) {
                return response()->json(["message" => __('Token expired.')],400);
            } else {
                if (!empty($token['token'])) {
                    if ($token['token'] == $queryToken) {
                        $tokenRepo->updateTokenUsage($request->input('hash'));
                        $this->guestService->updateEmailVerificationStatus($token->model_id, true);
                        return response()->json(["data" => array_merge(
                            ["message" => __('Token verified.')],
                            ["token" => $token]
                        )]);
                    }
                }
                return response()->json(["message" => "Wrong token or user."],400);
            }
        }
        return response()->json(["message" => "Wrong user id."],400);
    }
}
