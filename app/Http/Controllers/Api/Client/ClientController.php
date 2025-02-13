<?php
namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\ClientsRequests\ClientAllRequest;
use App\Http\Requests\ClientsRequests\ClientFindRequest;
use App\Services\ClientServices\ClientService;
use App\Services\UserServices\UsersAccountService;

class ClientController extends BaseApiController
{
    /**
     * ClientController constructor.
     * @param ClientService $clientService
     * @param UsersAccountService $usersAccountService
     */
    public function __construct(ClientService $clientService, UsersAccountService $usersAccountService)
    {   
        $this->clientService = $clientService;
        $this->usersAccountService = $usersAccountService;
    }

    /**
     * Display a listing of the clients
     */
    public function index(ClientFindRequest $request)
    {   
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            return response()->json($this->clientService->getAll()->toArray()); 
        }   
        return response()->json(['message' => 'No permission error'], 401);    
    }

    /** 
     * Find a client by id
     */
    public function find(ClientFindRequest $request, int $clientId)
    {   
        return response()->json($this->clientService->find($clientId,false)->toArray());
    }

    /** 
     * Find a client by id
     */
    public function findMyClients(ClientFindRequest $request)
    {   
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user()) && !auth()->user()->onBehalf) {
            return response()->json($this->clientService->getAll()->toArray());
        } else if (auth()->user()->onBehalf) { 
            return response()->json($this->clientService->findByMultipleIds([auth()->user()->onBehalf->id])->toArray());
        } else { 
            return response()->json($this->clientService->findByMultipleIds(auth()->user()->userable->assignedClients()->pluck('id')->toArray())->toArray());
        }
    }
}
