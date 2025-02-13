<?php

namespace App\Services\SoftwareOwnerServices;

use App\Repositories\SoftwareOwnerRepository;

/**
 * Class SoftwareOwnerService.
 *
 * @package App\Services\VerifyPhoneService
 */
class SoftwareOwnerService
{
    /** @var SoftwareOwnerRepository */
    protected $softwareOwnerRepository;

    /**
     * Create a new SoftwareOwnerService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->softwareOwnerRepository = app()->make(SoftwareOwnerRepository::class);
    }
    /**
     * Creates new Softwareowner
     *
     * @param array data
     * @return Softwareowner
     */
    public function create(array $data)
    {
        return $this->softwareOwnerRepository->create($data);
    }

}
