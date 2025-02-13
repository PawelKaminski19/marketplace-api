<?php

namespace App\Repositories;

use App\Models\Variant;

/**
 * Class VariantRepository.
 *
 * @package App\Repository
 */
class VariantRepository extends BaseRepository
{
    /**
     * Initialize repository instance.
     *
     * @param Variant $model
     */
    public function __construct(Variant $model)
    {
        parent::__construct();
        $this->model = $model;
    }
}
