<?php

namespace App\Repositories\i18n;

use App\Models\i18n\i18nImportStatus;
use App\Repositories\BaseRepository;

class i18nImportRepository extends BaseRepository
{
    public function __construct(i18nImportStatus $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
