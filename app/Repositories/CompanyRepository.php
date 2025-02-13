<?php

namespace App\Repositories;

use App\Models\Company;
use App\Http\Resources\RolesAndPermissions\RolesWithPermissionsResource;

/**
 * Class CompanyRepository.
 *
 * @package App\Repository
 */
class CompanyRepository extends BaseRepository
{
    /**
     * Initialize companies repository instance.
     *
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        $this->model = $model;
    }

}
