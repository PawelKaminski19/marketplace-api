<?php

namespace App\Repositories;

use App\Models\Country;
use App\Http\Resources\RolesAndPermissions\RolesWithPermissionsResource;

/**
 * Class CountryRepository.
 *
 * @package App\Repository
 */
class CountryRepository extends BaseRepository
{
    /**
     * Initialize countries repository instance.
     *
     * @param Country $model
     */
    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    /**
     * Find by iso code
     *
     * @param $iso
     * @return bool
     */
    public function findByIso(string $iso)
    {
        $country = $this->model->where('iso_code', '=', strtoupper($iso))->first();

        return $country;
    }
}
