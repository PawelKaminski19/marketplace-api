<?php

namespace App\Services\AddressServices;

use App\Repositories\AddressRepository;
use Uuid;

/**
 * Class AddressService.
 *
 * @package App\Services\AddressService
 */
class AddressService
{

    /**
     * Create a new CompanyService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addressRepository = app()->make(AddressRepository::class);
    }

    /**
     * Creates new Address
     *
     * @param array data
     * @return Address
     */
    public function create(array $data)
    {
        return $this->addressRepository->create($data);
    }

    /**
     * Update given Address
     *
     * @param int $id
     * @param array data
     * @return Address
     */
    public function update(int $id, array $data)
    {
        return $this->addressRepository->update($id, $data);
    }
}
