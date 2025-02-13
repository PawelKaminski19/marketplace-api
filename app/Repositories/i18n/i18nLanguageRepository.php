<?php

namespace App\Repositories\i18n;

use App\Models\i18n\i18nLanguage;
use App\Repositories\BaseRepository;

class i18nLanguageRepository extends BaseRepository
{
    public function __construct(i18nLanguage $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
