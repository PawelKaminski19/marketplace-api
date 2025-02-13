<?php

namespace App\Http\Controllers\Api\Admin\RolesAndPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PermissionRepository;
use App\Http\Resources\UsersRolesAndPermissions\PermissionCollectionResource;
use App\Http\Resources\UsersRolesAndPermissions\RolesWithPermissionsResource;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\NoPermissionException;
use App\Http\Controllers\Api\Admin\BaseAdminController;
use App\Services\UserServices\UsersAccountService;
use App\Services\UserServices\RolesService;
use App\Services\UserServices\PermissionsService;
use App\Repositories\RoleRepository;
use App\Repositories\ClientRepository;

class PermissionController extends BaseAdminController
{

    /**
     * @var PermissionRepository
     */
    protected $permissionRepo;
    /**
    * @var PermissionCollectionResource
     */
    protected $permissionCollectionResource;

    /**
    * @var RolesWithPermissionsResource
    */
    protected $rolesWithPermissionsResource;

    /**
     * Create a new PermissionController instance.
     * @param PermissionRepository $permissionRepo
     * @param PermissionCollectionResource $permissionCollectionResource
     * @param UsersAccountService $usersAccountService
     * @param permissionsService $permissionsService
     * @param RoleRepository $roleRepo
     * @param ClientRepository $clientRepository
     * @return void
     */
    public function __construct(PermissionRepository $permissionRepo, PermissionCollectionResource $permissionCollectionResource, UsersAccountService $usersAccountService, PermissionsService $permissionsService, RoleRepository $roleRepo, RolesWithPermissionsResource $rolesWithPermissionsResource,  ClientRepository $clientRepository)
    {
        parent::__construct();
        $this->permissionRepo = $permissionRepo;
        $this->permissionCollectionResource = $permissionCollectionResource;
        $this->usersAccountService = $usersAccountService;
        $this->permissionsService = $permissionsService;
        $this->roleRepo = $roleRepo;
        $this->rolesWithPermissionsResource = $rolesWithPermissionsResource;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function index()
    {
        //only a UberAdmin can list ALL permissions
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $this->permissionCollectionResource->setData($this->permissionRepo->getAll());
            return $this->permissionCollectionResource;
        }
        throw new NoPermissionException;
    }

    /**
     * Assign a permission to role
     * @param string $name
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function findByName(string $name)
    {
        if ($this->user->userable->hasPermissionTo('read permission')) {
            $this->permissionCollectionResource->setData($this->permissionRepo->findByName($name));
            return $this->permissionCollectionResource;
        }
        throw new NoPermissionException;
    }

    /**
     * Assing a permissions to role
     * @param string $name
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function assignPermissionsToRole(Request $request, int $permissionId, int $roleId)
    {
        /*
         * @var role
         * */
        $role = $this->roleRepo->find($roleId,false);
        if ($role && !is_null($role->client_id) ) {
             $clientId = $role->client_id;

             if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'update permission')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
                $this->permissionsService->assignPermissionsToRole($roleId, [$permissionId]);
                $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllRolesPermissionsByClientId($clientId));
                return $this->rolesWithPermissionsResource;
             }
        } else {
            if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
                $this->permissionsService->assignPermissionsToRole($roleId, [$permissionId]);
                $this->rolesWithPermissionsResource->setData($this->roleRepo->getCoreRolesPermissions());
                return $this->rolesWithPermissionsResource;
            }
        }
        throw new NoPermissionException;
    }

    /**
     * Revoke a permission from role
     * @param string $name
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function revokePermissionsFromRole(Request $request, int $permissionId, int $roleId)
    {
        /*
         * @var role
         * */
        $role = $this->roleRepo->find($roleId,false);
        if ($role && !is_null($role->client_id) ) {
             $clientId = $role->client_id;

             if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'delete permission')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
                $this->permissionsService->revokePermissionsFromRole($roleId, [$permissionId]);
                $this->rolesWithPermissionsResource->setData($this->roleRepo->getAllRolesPermissionsByClientId($clientId));
                return $this->rolesWithPermissionsResource;
             }
        } else {
            if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
                $this->permissionsService->revokePermissionsFromRole($roleId, [$permissionId]);
                $this->rolesWithPermissionsResource->setData($this->roleRepo->getCoreRolesPermissions());
                return $this->rolesWithPermissionsResource;
            }
        }
        throw new NoPermissionException;
    }

    /**
     * Display a listing of the resource based on given role id.
     * @param Request $request
     * @param int $roleId
     *
     * @return \Illuminate\Http\Response|NoPermissionException
     */
    public function updateRolesAndPermissions(Request $request, int $roleId)
    {
        /*
        * @var permissionsIds
        * */
        $permissionsIds = array_column($request->all(),'id');
        // permissions can be updated only when:
        // - a "update permission" permission is available for the logged in user
        // - logged in user changes permissions ONLY assigned to his client
        $clientAssigned = $this->user->userable->client;

        if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'update permission')  || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
            if ($clientAssigned) {
                $this->rolesService->updatePermissionsByRoleIdAndClientId($clientAssigned->id,$roleId,$permissionsIds);

                $this->singleRoleWithPermissionsResource->setData($this->rolesService->getById($roleId)->toArray());
                return $this->singleRoleWithPermissionsResource;

            }
        }
        throw new NoPermissionException;
    }
}
