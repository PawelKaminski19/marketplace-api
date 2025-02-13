<?php

namespace App\Repositories;

use App\Models\VariantGroup;

/**
 * Class VariantGroupRepository.
 *
 * @package App\Repository
 */
class VariantGroupRepository extends BaseRepository
{
    /**
     * Initialize repository instance.
     *
     * @param VariantGroup $model
     */
    public function __construct(VariantGroup $model)
    {
        parent::__construct();
        $this->model = $model;
    }
}
