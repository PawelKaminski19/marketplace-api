<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\OnBehalfCustomerLoginRequest;
use App\Http\Requests\UsersRequests\OnBehalfLoginRequest;
use App\Http\Resources\UsersRolesAndPermissions\OnBehalfResponseResource;
use App\Models\User;
use App\Services\UserServices\UsersOnBehalfService;
use Illuminate\Support\Facades\Auth;

class OnBehalfController extends Controller
{
    /**  @var UsersOnBehalfService */
    protected $usersOnBehalfService;

    /**  @var OnBehalfResponseResource */
    protected $onBehalfResponseResource;

    /**
     * Create a new UsersOnBehalfService instance.
     * @param UsersOnBehalfService $usersOnBehalfService
     * @param OnBehalfResponseResource $onBehalfResponseResource
     * @return void
     */
    public function __construct(UsersOnBehalfService $usersOnBehalfService, OnBehalfResponseResource $onBehalfResponseResource)
    {
        $this->usersOnBehalfService = $usersOnBehalfService;
        $this->onBehalfResponseResource = $onBehalfResponseResource;
    }

    /**
     * Changing the on behalf login
     *  we need to check if
     *  - user is a softwareowner of the given client
     *  - user is sys
     * @return \Illuminate\Http\JsonResponse
     */
    public function onBehalfLogin(OnBehalfLoginRequest $request)
    {
        // let's grab the clients id
        $clientId = $request['clientsId'];

        try {
            if ($clientId) {
                if ($this->usersOnBehalfService->canUserLoginOnBehalf(auth()->user(), $clientId)) {
                    $this->usersOnBehalfService->setOnBehalfEntity(auth()->user(), 'client', $clientId);
                    $this->onBehalfResponseResource->setData(auth()->user()->fresh());
                    return $this->onBehalfResponseResource;
                }
            }
        } catch (\Throwable $ex) {
            return response()->json([
                'error' => $ex->getMessage(),
            ]);
        }
        //default response
        return response()->json(['error' => 'Wrong Client Or Wrong Permissions'], 401);
    }

    /**
     * Changing the on behalf login
     *  we need to check if
     *  - user is a softwareowner of the given client
     *  - user is sys
     * @return \Illuminate\Http\JsonResponse
     */
    public function onBehalfCustomerLogin(OnBehalfCustomerLoginRequest $request)
    {
        // let's grab the clients id
        $all = $request->json()->all();
        $customersId = $all['customersId'];
        if ($customersId) {
            if ($this->usersOnBehalfService->canUserLoginOnBehalfCustomer(auth()->user(), $customersId)) {
                $this->usersOnBehalfService->setOnBehalfEntity(auth()->user(), 'customer', $customersId);
                $this->onBehalfResponseResource->setData(auth()->user()->fresh());
                return $this->onBehalfResponseResource;
            }
        }
        //default response
        return response()->json(['error' => 'Wrong Customer Or Wrong Permissions'], 401);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function onBehalfLogout()
    {
        if (auth()->user()) {
            $this->usersOnBehalfService->logoutOnBehalf(auth()->user()->id);
        }
        return response()->json(['message' => 'Successfully logged out']);
    }
}
