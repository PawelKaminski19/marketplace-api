<?php
namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\CountryServices\CountryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CountryController extends BaseApiController
{
    /**
     * CountryService constructor.
     * @param CountryService $countryService
     */
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the settings
     */
    public function index()
    {
        return response()->json($this->countryService->getAll()->toArray());
    }
}
