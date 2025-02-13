<?php
namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Http\Resources\RolesAndPermissions\RolesWithPermissionsResource;

/**
 * Class RoleRepository.
 *
 * @package App\Repository
 */
class RoleRepository extends BaseRepository
{
    /**
     * Initialize repository instance.
     *
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Get Role by id.
     *
     * @param int $id
     * @param bool $orFail
     *
     * @return Role
     */
    public function getByIdWithPermission($id)
    {
        return $this->model->with('permissions')
                           ->find($id);
    }

    /**
     * Get all with permission assigned.
    *
    * @return Model[]|Collection
     */
    public function getAllWithPermissions()
    {
        return $this->model->with('permissions')
                           ->get();
    }

    /**
    * Get core roles and permissions
    * @return Model[]|Collection
    */
    public function getCoreRolesPermissions()
    {
        return $this->model->whereNull('client_id')
                           ->get();
    }

    /**
    * Get all roles and permissions by client id
    * @param int $clientId
    * @return Model[]|Collection
    */
    public function getAllRolesPermissionsByClientId(int $clientId)
    {
        return $this->model->where('client_id', $clientId)
                           ->get();
    }

    /**
    * Get a role and permissions by client id and role name.
    * @param int $clientId
    * @param string $name
    *
    * @return Collection
    */
    public function getAllRolesPermissionsByClientIdAndRoleName(int $clientId, string $name)
    {
        return $this->model->with('permissions')
                           ->where('client_id', $clientId)
                           ->where('name', $name)
                           ->get();
    }

    /**
    * Get a role by client id and role id
    * @param int $clientId
    * @param int $roleId
    *
    * @return Role
    */
    public function getGivenRolePermissionsByClientId(int $clientId, int $roleId)
    {
        return $this->model->with('permissions')
                           ->where('client_id', $clientId)
                           ->where('id', $roleId)
                           ->first();
    }

    /**
    * Assigns role to user
    * @param int $roleId
    * @param int $userId
    *
    * @return bool
    */
    public function assignRoleToUser(int $roleId, int $userId)
    {
        $roleObj = $this->model->find($roleId);
        if ($roleObj) {
            $user = User::find($userId);
            return$user->assignRole($roleObj);
        }
        return false;
    }

    /**
    * Removes role from user
    * @param int $roleId
    * @param int $userId
    *
    * @return bool
    */
    public function revokeRoleFromUser(int $roleId, int $userId)
    {
        $roleObj = $this->model->find($roleId);
        if ($roleObj) {
            $user = User::find($userId);
            return$user->removeRole($roleObj);
        }
        return false;
    }
}
