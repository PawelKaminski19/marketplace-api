<?php

namespace App\Services\UserServices;

use App\Repositories\PermissionRepository;

/**
 * Class PermissionsService.
 * @package App\Services\UserServices
 */
class PermissionsService
{

    /**
     * Create a new PermissionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->permissionRepo = app()->make(PermissionRepository::class);
    }

    /**
     * Assign a permission to role
     *
     * @return string
     */
    public function assignPermissionsToRole(int $roleId, array $permissions)
    {
        return $this->permissionRepo->assignPermissionsToRole($roleId, $permissions);
    }

    /**
     * Assign a permission to role
     *
     * @return string
     */
    public function revokePermissionsFromRole(int $roleId, array $permissions)
    {
        return $this->permissionRepo->revokePermissionsFromRole($roleId, $permissions);
    }
}
