<?php

namespace App\Observers\i18n;

use App\Models\i18n\i18nTranslation;
use App\Services\i18nServices\i18nTranslationService;

class Translation
{
    public function saved(i18nTranslation $translation)
    {
        (new i18nTranslationService())->rebuildCache();
    }
}
