<?php

namespace App\Services\CompanyServices;

use App\Repositories\CompanyRepository;
use App\Services\DomainServices\DomainService;
use Uuid;

/**
 * Class CompanyService.
 *
 * @package App\Services\CompanyService
 */
class CompanyService
{

    /**
     * Create a new CompanyService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->companyRepository = app()->make(CompanyRepository::class);
    }

    /**
     * Creates new Company
     *
     * @param array data
     * @return Company
     */
    public function create(array $data)
    {
        return $this->companyRepository->create(array_merge($data, ["uuid" => Uuid::generate(4)]));
    }

    /**
     * Update given Company
     *
     * @param int $id
     * @param array data
     * @return Company
     */
    public function update(int $id, array $data)
    {
        return $this->companyRepository->update($id, array_merge($data, ["active" => "1"]));
    }
}
