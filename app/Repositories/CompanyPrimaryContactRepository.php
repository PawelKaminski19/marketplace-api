<?php

namespace App\Repositories;

use App\Models\CompanyPrimaryContact;

/**
 * Class CompanyPrimaryContactRepository.
 *
 * @package App\Repository
 */
class CompanyPrimaryContactRepository extends BaseRepository
{
    /**
     * Initialize companies primary contacts repository instance.
     *
     * @param CompanyPrimaryContact $model
     */
    public function __construct(CompanyPrimaryContact $model)
    {
        $this->model = $model;
    }

}
