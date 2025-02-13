<?php

namespace App\Http\Resources\UsersRolesAndPermissions;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollectionResource extends ResourceCollection
{

    /**
     * @var Collection
     */
    protected $data;

    /**
     * PermissionCollectionResource constructor.
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
     * Preparing data, removing unnecessary fields, adding related informations
     */
    private function prepareData(): array
    {
        return $this->data->toArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return
        $this->prepareData();
    }
}
