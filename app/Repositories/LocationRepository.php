<?php

namespace App\Repositories;

use App\Models\Location;

/**
 * Class EmployeeRepository.
 *
 * @package App\Repository
 */
class LocationRepository extends BaseRepository
{
    /**
     * Initialize Location repository instance.
     *
     * @param Location $model
     */
    public function __construct(Location $model)
    {
        $this->model = $model;
    }
}
