<?php

namespace App\Services\UserServices;

use App\Models\User;
use App\Repositories\RoleRepository;

/**
 * Class RolesService.
 * @package App\Services\UserServices
 */
class RolesService
{

    /**
     * Create a new RolesService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->roleRepo = app()->make(RoleRepository::class);
        $this->rolesWithPermissionsResource = app()->make(RolesWithPermissionsResource::class);
    }

    /**
     * Get Roles by Fole id
     * @param int $roleId
     * @return string
     */
    public function getById(int $roleId)
    {
        return $this->roleRepo->getByIdWithPermission($roleId);
    }

    /**
     * Get Core Roles
     * @return string
     */
    public function getCoreRolesPermissions()
    {
        return $this->roleRepo->getCoreRolesPermissions();
    }

    /**
     * Get Roles by Client id and Role Name
     * @param int $clientId
     * @param string $name
     * @return string
     */
    public function getAllRolesPermissionsByByClientIdAndRoleName(int $clientId, string $name)
    {
        return $this->roleRepo->getAllRolesPermissionsByClientIdAndRoleName($clientId, $name);
    }

    /**
     * Get Roles by Client id
     * @param int $clientId
     * @return string
     */
    public function getAllRolesPermissionsByClientId(int $clientId)
    {
        return $this->roleRepo->getAllRolesPermissionsByClientId($clientId);
    }

    /**
     * Get Roles by Client id and Role Name
     * @param int $roleId
     * @param int $clientId
     * @param array $permissionsIds
     * @return string
     */
    public function updatePermissionsByRoleIdAndClientId(int $roleId, int $clientId, array $permissionsIds)
    {
        return $this->roleRepo->updatePermissionsByRoleIdAndClientId($roleId, $clientId, $permissionsIds);
    }

    /**
     * Store a new CORE role
     * @param array $data
     * @return string
     */
    public function storeCoreRole(array $data)
    {
        return $this->roleRepo->create(array_merge($data, ["core" => "1"]));
    }

    /**
     * Store a new role
     * @param array $data
     * @return string
     */
    public function storeRole(array $data)
    {
        return $this->roleRepo->create($data);
    }

    /**
     * Store a new role
     * @param int $roleId
     * @param array $data
     * @return string
     */
    public function updateRole(int $roleId, array $data)
    {
        return $this->roleRepo->update($roleId, $data);
    }

    /**
     * Store a new role
     * @param int $roleId
     * @param array $data
     * @return string
     */
    public function updateCoreRole(int $roleId, array $data)
    {
        return $this->roleRepo->update($roleId, $data);
    }

    /**
     * Assign a role to user
     * @param int $roleId
     * @param int $userId
     * @return string
     */
    public function assignRoleToUser(int $roleId, int $userId)
    {
        return $this->roleRepo->assignRoleToUser($roleId, $userId);
    }

    /**
     * Revoke a role from user
     * @param int $roleId
     * @param int $userId
     * @return string
     */
    public function revokeRoleFromUser(int $roleId, int $userId)
    {
        return $this->roleRepo->revokeRoleFromUser($roleId, $userId);
    }

    /**
     * Assign a permission to role
     * @param int $roleId
     * @param array $permissions
     * @return string
     */
    public function assignRoleFromUser(int $roleId, array $permissions)
    {
        return $this->permissionRepo->revokePermissionsFromRole($roleId, $permissions);
    }

    /**
     * Checking if role can be assigned to User
     * @param int $clientId
     * @param User $user
     * @return bool
     */
    public function canRoleBeAssignedToUser(int $clientId, User $user)
    {
        foreach ($user->affiliates as $affiliate) {
            foreach ($affiliate->clients as $client) {
                if ($client && $client->id == $clientId) {
                    return true;
                }
            }
        }

        foreach ($user->employees as $employee) {
            foreach ($employee->clients as $client) {
                if ($client && $client->id == $clientId) {
                    $canUpdate = true;
                    return true;
                }
            }
        }

        foreach ($user->customers as $customer) {
            foreach ($customer->clients as $client) {
                if ($client && $client->id == $clientId) {
                    $canUpdate = true;
                    return true;
                }
            }
        }
        return false;
    }
}
