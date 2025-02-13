<?php

namespace App\Observers\i18n;

use App\Models\i18n\i18nKey;
use App\Services\i18nServices\i18nTranslationService;

class Key
{
    public function saved(i18nKey $key)
    {
        (new i18nTranslationService())->rebuildCache();
    }
}
