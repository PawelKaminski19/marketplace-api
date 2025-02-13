<?php
namespace App\Http\Resources\UsersRolesAndPermissions;

use App\Repositories\RoleRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RolesWithPermissionsResource extends ResourceCollection
{
    /**
     * @var RoleRepository
     */
    protected $roleRepo;

    /**
     * @var Collection
     */
    protected $data;

    /**
     * RolesWithPermissionsResource constructor.
     * @param RoleRepository $roleRepo
     */
    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;

        parent::__construct(collect());
    }

    /**
     * Preparing data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getRolesWithPermissions(): array
    {
        $this->data->map(function ($role) {
            $role->permissions->map(function ($perm) {
                unset($perm->pivot);
            });
        });
        return $this->data->toArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return
        $this->getRolesWithPermissions();
    }
}
