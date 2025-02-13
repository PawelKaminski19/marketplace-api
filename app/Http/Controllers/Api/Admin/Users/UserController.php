<?php

namespace App\Http\Controllers\Api\Admin\Users;

use App\Exceptions\NoPermissionException;
use App\Http\Controllers\Api\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\getByClient;
use App\Http\Resources\UsersRolesAndPermissions\UsersCollectionResource;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use App\Services\UserServices\UsersAccountService;
use App\Services\UserServices\UsersService;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseAdminController
{

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @var UsersService
     */
    protected $usersService;

    /**
     * @var UsersAccountService
     */
    protected $usersAccountService;

    /**
     * @var UsersResource
     */
    protected $usersResource;

    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * Create a new UserController instance.
     *
     * @param UserRepository $userRepo
     * @param UsersService $usersService
     * @param UsersAccountService $usersAccountService
     * @param UsersResource $usersResource
     * @param ClientRepository $clientRepository
     * @return void
     */
    public function __construct(UserRepository $userRepo, UsersService $usersService,
        UsersAccountService $usersAccountService, UsersCollectionResource $usersResource,
        ClientRepository $clientRepository) {
        parent::__construct();
        $this->userRepo = $userRepo;
        $this->usersService = $usersService;
        $this->usersAccountService = $usersAccountService;
        $this->usersResource = $usersResource;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the resource by client id.
     * @param int $clientId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function index()
    {
        //only a UberAdmin can list ALL users
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $this->usersResource->setData($this->usersService->getAll());
            return $this->usersResource;
        }
        throw new NoPermissionException;
    }
    /**
     * Display a listing of the resource by client id.
     * @param int $clientId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function getByClient(GetByClientRequest $request, int $clientId)
    {
        $this->usersResource->setData($this->usersService->getAllUsersByClientId($clientId));
        return $this->usersResource;
       
        throw new NoPermissionException;
    }

}
