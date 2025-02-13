<?php
namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Api\BaseApiController;

class CompanyController extends BaseApiController
{
    /**
     * LocationController constructor.
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }
}
