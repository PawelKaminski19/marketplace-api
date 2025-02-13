<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;

/**
 * Class PermissionRepository.
 *
 * @package App\Repository
 */
class PermissionRepository extends BaseRepository
{
    /**
     * Initialize permission repository instance.
     *
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
        $this->roleModel = app()->make(Role::class);
    }

    /**
     * Get by permission name.
     *
     * @param int $name
     *
     * @return Model
     */
    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }

    /**
    * Updates the permissions by role
    * @param int $roleId
    * @param array $values
    *
    * @return bool
    */
    public function assignPermissionsToRole(int $roleId, array $permissions)
    {
        $roleObj = $this->roleModel->find($roleId);
        if ($roleObj) {
            return $roleObj->permissions()->syncWithoutDetaching($permissions);
        }
        return false;
    }

    /**
    * Updates the permissions by role
    * @param int $roleId
    * @param array $permissions
    *
    * @return bool
    */
    public function revokePermissionsFromRole(int $roleId, array $permissions)
    {
        $roleObj = $this->roleModel->find($roleId);
        if ($roleObj) {
            return $roleObj->permissions()->detach($permissions);
        }
        return false;
    }
}
