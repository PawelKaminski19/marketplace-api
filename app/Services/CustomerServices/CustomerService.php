<?php

namespace App\Services\CustomerServices;

use App\Models\Client;
use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Uuid;

/**
 * Class CustomerService.
 *
 * @package App\Services\CustomerService
 */
class CustomerService
{

    /**
     * Create a new CustomerService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
        $this->customerRepository = app()->make(CustomerRepository::class);
    }


    /**
     * Finds Customer by id
     *
     * @param int $id
     * @return Country
     */
    public function find(int $id)
    {
        return $this->customerRepository->find($id);
    }
    /**
     * Find customer by email
     *
     * @param string $email
     * @param int $website_id
     * @return Model
     */
    public function findByEmailAndWebsite(string $email, int $websiteId)
    {
        return $this->userRepository->findByEmailAndWebsite($email,$websiteId);

    }
}
