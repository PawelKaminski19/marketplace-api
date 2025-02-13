<?php

namespace App\Http\Resources\CategoryResources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategorySearchCollectionResource extends ResourceCollection
{

    /**
     * @var Collection
     */
    protected $data;

    /**
     * SettingsUploadsCollectionResource constructor.
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
        $res = $this->data->toArray();
        $res['parent'] = $this->data->parent->toArray();
        $res['child'] = $this->data->child->toArray();

        return $res;
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
