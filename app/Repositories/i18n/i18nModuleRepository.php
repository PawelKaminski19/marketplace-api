<?php

namespace App\Repositories\i18n;

use App\Models\i18n\i18nModule;
use App\Repositories\BaseRepository;

class i18nModuleRepository extends BaseRepository
{
    public function __construct(i18nModule $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function all($columns = ['*'])
    {
        return $this->query()->orderBy('name')->get();
    }
}
