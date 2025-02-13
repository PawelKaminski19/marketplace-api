<?php

namespace App\Http\Controllers\Api\Admin\RolesAndPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Packages\AccountType;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Http\Resources\UsersRolesAndPermissions\RolesWithPermissionsResource;
use App\Http\Resources\UsersRolesAndPermissions\SingleRoleWithPermissionsResource;
use App\Services\UserServices\RolesService;
use App\Services\UserServices\UsersAccountService;
use App\Exceptions\NoPermissionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Admin\BaseAdminController;
use App\Repositories\ClientRepository;
use App\Http\Requests\RolesAndPermissionsRequests\NewCoreRoleRequest;
use App\Http\Requests\RolesAndPermissionsRequests\NewRoleRequest;
use App\Http\Requests\RolesAndPermissionsRequests\UpdateRoleRequest;
use App\Http\Requests\RolesAndPermissionsRequests\UpdateCoreRoleRequest;

class RoleController extends BaseAdminController
{

    /**
     * @var RoleRepository
     */
    protected $roleRepo;

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
    * @var RolesWithPermissionsResource
     */
    protected $rolesWithPermissionsResource;

    /**
    * @var SingleRoleWithPermissionsResource
     */
    protected $singleRoleWithPermissionsResource;

    /**
    * @var rolesService
     */
    protected $rolesService;

    /**
     * Create a new RoleController instance.
     *
     * @param UserRepository $userRepo
     * @param RoleRepository $roleRepo
     * @param RolesWithPermissionsResource $rolesWithPermissionsResource
     * @param rolesService $rolesService
     * @param UsersAccountService $usersAccountService
     * @param SingleRoleWithPermissionsResource $singleRoleWithPermissionsResource
     * @return void
     */
    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, RolesWithPermissionsResource $rolesWithPermissionsResource, RolesService $rolesService,
     UsersAccountService $usersAccountService, SingleRoleWithPermissionsResource $singleRoleWithPermissionsResource, ClientRepository $clientRepository)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->rolesWithPermissionsResource = $rolesWithPermissionsResource;
        $this->rolesService = $rolesService;
        $this->singleRoleWithPermissionsResource = $singleRoleWithPermissionsResource;
        $this->usersAccountService = $usersAccountService;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function index()
    {
        //only a UberAdmin can list ALL roles
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllWithPermissions());
            return $this->rolesWithPermissionsResource;
        }
        throw new NoPermissionException;
    }

    /**
     * Add new role.
     *
     * @param NewRoleRequest $request
     * @param int $clientId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function storeByClient(NewRoleRequest $request, int $clientId)
    {
        // very important
        // user can store new role only if:
        // condition 1 - he has the CREATE ROLE permission for given CLIENT, and given USER
        // condition 2 - he is the SOFTWARE OWNER of the given client
        // condition 3 - he is a UBER ADMIN, so the SYSTEM OWNER
        if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'create role')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {

            $this->rolesService->storeRole(["name" => $request->get('name'),
                                            "client_id" => $clientId]);

            $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllWithPermissions());
            return $this->rolesWithPermissionsResource;
        }
        throw new NoPermissionException;
    }

    /**
     * Add new CORE role.
     *
     * @param NewCoreRoleRequest $request
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function storeCore(NewCoreRoleRequest $request)
    {
        //only a UberAdmin can create a CORE role
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $this->rolesService->storeCoreRole(["name" => $request->get('name')]);
            $this->rolesWithPermissionsResource->setData($this->roleRepo->getCoreRolesPermissions());
            return $this->rolesWithPermissionsResource;
        }
        throw new NoPermissionException;
    }

    /**
     * Update role.
     *
     * @param NewCoreRoleRequest $request
     * @param int $clientId
     * @param int $roleId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function updateByClient(UpdateRoleRequest $request, int $roleId, int $clientId)
    {
        /*
         * @var role
         * */
        $role = $this->roleRepo->find($roleId,false);
        if ($role && !is_null($role->client_id) ) {
                if ($role->client_id != $clientId) {
                    return response()->json(['error' => 'Role not found.'], 401);
                } else {
                    if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'update role')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
                        $this->rolesService->updateRole($roleId,["name" => $request->get('name')]);

                        $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllRolesPermissionsByClientId($clientId));
                        return $this->rolesWithPermissionsResource;
                    } else {
                        throw new NoPermissionException;
                    }
                }
            }
        throw new NoPermissionException;
    }

    /**
     * Update a CORE role.
     *
     * @param UpdateCoreRoleRequest $request
     * @param int $roleId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function updateCore(UpdateCoreRoleRequest $request, int $roleId)
    {
        /*
         * @var role
         * */
        $role = $this->roleRepo->find($roleId,false);
        if ($role) {
            if (is_null($role->client_id)) {
                if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {

                    $this->rolesService->updateCoreRole($roleId,["name" => $request->get('name')]);

                    $this->rolesWithPermissionsResource->setData($this->roleRepo->getCoreRolesPermissions());
                    return $this->rolesWithPermissionsResource;
                } else {
                    throw new NoPermissionException;
                }
            } else {
                return response()->json(['error' => 'This is not a core role.'], 401);
            }
        }
        throw new NoPermissionException;
    }


    /**
     * Display a listing of the resource by client id.
     * @param int $clientId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function getByClient(int $clientId)
    {
        //firstly let's grab the clients id from the URL and try to find it in the database

        /*
        * @var client
        * */
        $client = $this->clientRepository->find($clientId,false);

        if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'read role')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
            // role can be read only when:
            // - a "read role" permission is available for the logged in user
            // - a softwareowner is logged in
            $this->rolesWithPermissionsResource->setData($this->rolesService->getAllRolesPermissionsByClientId($clientId));
            return $this->rolesWithPermissionsResource;
        }
        throw new NoPermissionException;
    }

    /**
     * Display a listing of the resource by client id.
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function getCore()
    {
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            // role can be read only when:
            // - a "read role" permission is available for the logged in user
            $this->rolesWithPermissionsResource->setData($this->rolesService->getCoreRolesPermissions());
            return $this->rolesWithPermissionsResource;
        }
        throw new NoPermissionException;
    }


    /**
     * Display a listing of the resource by client id and role name.
     * @param int $clientId
     * @param string $name
     *
     * @return \Illuminate\Http\Response
     */
    public function getByClientAndByName(int $clientId, string $name)
    {
        if ($this->user->hasPermissionTo('read role')) {
            // role can be read only when:
            // a "read role" permission is available for the logged in user
            $this->rolesWithPermissionsResource->setData($this->rolesService->getAllRolesPermissionsByByClientIdAndRoleName($clientId, $name));
            return $this->rolesWithPermissionsResource;
        }
        throw new NoPermissionException;
    }


    /**
     * Delete a role by id.
     * @param NewRoleRequest $request
     * @param int $clientId
     * @param int $role
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function delete(NewRoleRequest $request, int $clientId, int $role)
    {

        if ($this->user->hasPermissionTo('delete role') && $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
            $this->clientRepository->delete($clientId);
            return response()->json(['message' => 'Deleted'], 200);
        }
        throw new NoPermissionException;
    }

    /**
     * Assing a role to user
     * @param int $roleId
     * @param int $userId
     * @param int $clientId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function assignRoleToUser(Request $request, int $roleId, int $userId, int $clientId)
    {
        /*
         * @var role
         * */
        $role = $this->roleRepo->find($roleId,false);
        if ($role) {
            /*
             * @var user
             * */
            $user = $this->userRepo->find($userId,false);
             /*
              * @var $accounts
              * */
            $accounts = $this->usersAccountService->getAccountsByUser($user);
             /*
              * @var user
              * */
            $canUserBeAssigned = $this->rolesService->canRoleBeAssignedToUser($clientId, $user);


            if ($canUserBeAssigned && $this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'update role')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
                $this->rolesService->assignRoleToUser($roleId,$userId);
                $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllRolesPermissionsByClientId($clientId));
                return $this->rolesWithPermissionsResource;
             }
        }
        throw new NoPermissionException;
    }


    /**
     * Revoke a role from user
     * @param int $roleId
     * @param int $userId
     * @param int $clientId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function revokeRoleFromUser(Request $request, int $roleId, int $userId, int $clientId)
    {
        /*
         * @var role
         * */
        $role = $this->roleRepo->find($roleId,false);
        if ($role) {
            /*
             * @var user
             * */
            $user = $this->userRepo->find($userId,false);
             /*
              * @var $accounts
              * */
            $accounts = $this->usersAccountService->getAccountsByUser($user);
             /*
              * @var user
              * */
            $canUserBeAssigned = $this->rolesService->canRoleBeAssignedToUser($clientId, $user);


            if ($canUserBeAssigned && $this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'update role')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
                $this->rolesService->revokeRoleFromUser($roleId,$userId);
                $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllRolesPermissionsByClientId($clientId));
                return $this->rolesWithPermissionsResource;
             }
        }
        throw new NoPermissionException;
    }

}
