<?php

namespace App\Repositories\i18n;

use App\Models\i18n\i18nTranslation;
use App\Repositories\BaseRepository;

class i18nTranslationRepository extends BaseRepository
{
    protected $additionalData;

    public function __construct(i18nTranslation $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
