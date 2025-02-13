<?php

namespace App\Services\ClientServices;

use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Services\DomainServices\DomainService;
use Uuid;

/**
 * Class ClientService.
 *
 * @package App\Services\ClientService
 */
class ClientService
{

    /**
     * Create a new ClientService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clientRepository = app()->make(ClientRepository::class);
        $this->domainService = app()->make(DomainService::class);
    }

    /**
     * Create a Client using Guest instance.
     *
     * @return Client
     */
    public function createFromGuest($gs)
    {
        $name = $gs->firstname . $gs->lastname . Uuid::generate(4);
        $client = $this->clientRepository->create([
            "username" => $name,
            "active" => 1,
            "slug" => Uuid::generate(4),
        ]);
        return $client;
    }
    /**
     * Find client by id
     *
     * @param int $clientId
     * @return Model
     */
    public function find(int $clientId, $orFail = true)
    {
        return $this->clientRepository->find($clientId, false);

    }

    /**
     * Get by list of ids.
     *
     * @param array $clients
     * @return Model[]|Collection
     */
    public function findByMultipleIds(array $clients)
    {
        return $this->clientRepository->findByMultipleIds($clients);
    }

    /**
     * get all clients
     *
     * @return Model
     */
    public function getAll()
    {
        return $this->clientRepository->getAll();

    }

    /**
     * Update given Client
     *
     * @param int $id
     * @param array data
     * @return Client
     */
    public function update(int $id, array $data)
    {
        return $this->clientRepository->update($id, $data);
    }

    /**
     * Get a domain assigned to software owner
     *
     * @return Model
     */
    public function getSoftwareOwner()
    {
        return $this->clientRepository->getSoftwareOwner();
    }
}
