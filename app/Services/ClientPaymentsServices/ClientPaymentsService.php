<?php

namespace App\Services\ClientPaymentsServices;

use App\Repositories\ClientPaymentsRepository;

class ClientPaymentsService
{
    private $clientPaymentsRepository;

    /**
     * Create a new CompanyService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clientPaymentsRepository = app()->make(ClientPaymentsRepository::class);
    }

    /**
     * Creates new Client Payments Record
     *
     * @param array data
     * @return ClientPayment
     */
    public function create(array $data)
    {
        return $this->clientPaymentsRepository->create(array_merge($data, ["active" => 1]));
    }
}
