<?php
namespace App\Http\Controllers\Api\Gender;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\CreateShopRequest;
use App\Services\GenderServices\GenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GenderController extends BaseApiController
{
    /**
     * GenderService constructor.
     * @param GenderService $genderService
     */
    public function __construct(GenderService $genderService)
    {
        $this->genderService = $genderService;
    }

    /**
     * Display a listing of the settings
     */
    public function index()
    {
        return response()->json($this->genderService->getAll()->toArray());
    }
}
