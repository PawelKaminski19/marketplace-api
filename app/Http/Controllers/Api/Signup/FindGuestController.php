<?php

namespace App\Http\Controllers\Api\Signup;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\FindGuestRequest;
use App\Services\SignupServices\GuestService;

class FindGuestController extends BaseApiController
{
    /**
     * @param GuestService $guestService
     */
    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    /**
     * Finding the Guest by uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByUuid(FindGuestRequest $request)
    {
        $data = $request->all();
        $uuid = $data['uuid'] ?? null;
        $gs = $this->guestService->findByUuid($uuid);
        if ($uuid && $gs) {
            return response()->json($gs->getRelated());
        }
        return response()->json(["message" => "Guest not found."]);
    }
}
