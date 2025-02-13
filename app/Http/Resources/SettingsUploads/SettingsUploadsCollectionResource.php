<?php

namespace App\Http\Resources\SettingsUploads;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingsUploadsCollectionResource extends ResourceCollection
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
        return $this->data;
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
