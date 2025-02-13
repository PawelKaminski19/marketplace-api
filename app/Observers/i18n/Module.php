<?php

namespace App\Observers\i18n;

use App\Models\i18n\i18nModule;
use App\Services\i18nServices\i18nTranslationService;

class Module
{
    public function saved(i18nModule $module)
    {
        (new i18nTranslationService())->rebuildCache();
    }
}
