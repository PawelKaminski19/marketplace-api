<?php

namespace App\Repositories;

use App\Models\Softwareowner;

/**
 * Class SoftwareOwnerRepository.
 *
 * @package App\Repository
 */
class SoftwareOwnerRepository extends BaseRepository
{
    /**
     * Initialize Softwareowner repository instance.
     *
     * @param Softwareowner $model
     */
    public function __construct(Softwareowner $model)
    {
        $this->model = $model;
    }
}
