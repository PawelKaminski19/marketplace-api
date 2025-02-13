<?php
namespace App\Http\Controllers\Api\Constant;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\CreateShopRequest;
use App\Services\CountryServices\CountryService;
use App\Services\GenderServices\GenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConstantController extends BaseApiController
{
    /**
     * ConstantController constructor.
     * @param CountryService $countryService
     * @param GenderService $genderService
     */
    public function __construct(CountryService $countryService, GenderService $genderService)
    {
        $this->countryService = $countryService;
        $this->genderService = $genderService;

    }

    /**
     * Display a listing of the settings
     */
    public function index(Request $request)
    {
        $query = $request->all();
        $entities = explode(",",$query["query"]);

        $result = [];
        if (count($entities)>0) {
            foreach ($entities as $entity) {
                if ($entity === "country") {
                    $result["country"] = $this->countryService->getAll()->toArray();
                }
                if ($entity === "gender") {
                    $result["gender"] = $this->genderService->getAll()->toArray();
                }
            }
        }
        return response()->json($result);
    }
}
