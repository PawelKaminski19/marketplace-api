<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\WebsitesRequests\FindWebsiteRequest;
use App\Services\UserServices\UsersAccountService;
use App\Services\WebsiteServices\WebsiteService;
use Illuminate\Http\Request;

class WebsiteController extends BaseApiController
{
    /**  @var WebsiteService */
    protected $websiteService;

    /**  @var UsersAccountService */
    protected $usersAccountService;

    public function __construct(Request $request, WebsiteService $websiteService, UsersAccountService $usersAccountService)
    {
        parent::__construct();
        $this->websiteService = $websiteService;
        $this->usersAccountService = $usersAccountService;
    }

    /**
     * Get the website by id
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function find(FindWebsiteRequest $request, int $id)
    {
        //ONLY systemowner can collect data by website id only
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            return response()->json($this->websiteService->getById($id));
        }
        return response()->json(['error' => 'No permission.'], 401);
    }

    /**
     * Get the website by id and client id
     *
     * @param Request $request
     * @param int $id
     * @param int $clientId
     * @return mixed
     */
    public function findByClient(FindWebsiteRequest $request, int $id, int $clientId)
    {
        return response()->json($this->websiteService->getByIdAndClient($id, $clientId));
    }

    /**
     * Get the website by id and client id
     *
     * @param Request $request
     * @param int $id
     * @param int $clientId
     * @return mixed
     */
    public function findByURL(Request $request)
    {
        if (empty($this->domain)) {
            return response()->json(['error' => 'Please provide the correct domain name'], 401);
        }

        return response()->json($this->domain->website->load('client'));
    }

}
