<?php

namespace App\Repositories;

use App\Models\Gender;
use App\Http\Resources\RolesAndPermissions\RolesWithPermissionsResource;

/**
 * Class GenderRepository.
 *
 * @package App\Repository
 */
class GenderRepository extends BaseRepository
{
    /**
     * Initialize genders repository instance.
     *
     * @param Gender $model
     */
    public function __construct(Gender $model)
    {
        $this->model = $model;
    }

}
