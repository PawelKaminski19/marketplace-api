<?php

namespace App\Http\Resources\UsersRolesAndPermissions;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OnBehalfResponseResource extends ResourceCollection
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
     * Preparing data, removing unnecessary fields
     */
    private function prepareData()
    {
        $result = $this->data->toArray();

        if ($this->data->onBehalf) {
            $accountName = strtolower(substr(strrchr(get_class($this->data->onBehalf), "\\"), 1));

            $result["logged_on_behalf"][$accountName] = $this->data->onBehalf;
            $result["logged_on_behalf"]["onbehalf_time"] = $this->data->onbehalf_time;
        }
        return $result;
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
