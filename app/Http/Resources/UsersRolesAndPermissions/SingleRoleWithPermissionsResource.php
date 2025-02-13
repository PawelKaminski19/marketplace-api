<?php

namespace App\Http\Resources\UsersRolesAndPermissions;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SingleRoleWithPermissionsResource extends ResourceCollection
{

    /**
     * @var Collection
     */
    protected $data;

    /**
     * SingleRoleWithPermissionsResource constructor.
     */
    public function __construct()
    {
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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return
        $this->data;
    }
}
