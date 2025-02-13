<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Http\Resources\RolesAndPermissions\RolesWithPermissionsResource;

/**
 * Class CustomerRepository.
 *
 * @package App\Repository
 */
class CustomerRepository extends BaseRepository
{
    /**
     * Initialize clients repository instance.
     *
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }
}
