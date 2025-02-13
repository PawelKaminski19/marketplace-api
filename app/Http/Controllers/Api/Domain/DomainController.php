<?php
namespace App\Http\Controllers\Api\Domain;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\DomainServices\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DomainsRequests\DomainSearchRequest;

class DomainController extends BaseApiController
{
    /**
     * DomainService constructor.
     * @param DomainService $domainService
     */
    public function __construct(DomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    /**
     * Display a listing of the domain
     */
    public function index()
    {
        return response()->json($this->domainService->getAll()->toArray());
    }

    /**
     * Display a listing of the domain by url
     */
    public function searchByUrl(DomainSearchRequest $request)
    {
        $data = $request->all();

        $domain = $this->domainService->findByDomain($data['url']);
        if ($domain) {
            return response()->json($domain->load('client','website')->toArray());
        }

        return response()->json(["error" => "Wrong domain url or url not found."]);
    }
}
