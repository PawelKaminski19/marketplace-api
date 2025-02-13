<?php
namespace App\Http\Resources\GuestResources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{

    /**
     * @var Collection
     */
    protected $data;


    /**
     * GuestResource Constructor
     */
    public function __construct()
    {
        parent::__construct(collect());
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Preparing data, removing unnecessary fields
     */
    private function prepareData()
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
