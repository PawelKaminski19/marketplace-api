<?php

namespace App\Repositories;

use App\Models\Affiliate;
use App\Models\User;
use App\Models\Customer;
use App\Models\Softwareowner;
use App\Models\Employee;

/**
 * Class EmployeeRepository.
 *
 * @package App\Repository
 */
class EmployeeRepository extends BaseRepository
{
    /**
     * Initialize employee repository instance.
     *
     * @param Employee $model
     */
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }
}
