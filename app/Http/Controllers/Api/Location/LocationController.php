<?php
namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\CreateShopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationController extends BaseApiController
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
