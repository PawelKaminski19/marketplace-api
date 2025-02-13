<?php
namespace App\Http\Resources\SignupResources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateCompanyResource extends JsonResource
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
        $data = $this->data;
        unset($data["company"]["uuid"]->bytes);

        $data["location"]["address"] = $data["address"];
        $data["company"]["location"] = $data["location"]["address"];
        $data["client"]["company"] = $data["company"];

        unset($data["company"]["location_id"]);
        unset($data["company"]["location"]["gender_id"]);
        unset($data["company"]["location"]["country_id"]);
        unset($data["location_id"]);
        unset($data["location"]);
        unset($data["address"]);
        unset($data["company"]);

        return $data;
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
