<?php

namespace App\Services\i18nServices\Loaders;

use App\Services\i18nServices\i18nTranslationService;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;

class DefaultLoader implements TranslationLoader
{
    protected $translations;

    public function __construct()
    {
        $this->translations = (new i18nTranslationService())->getSiteTranslations();
    }

    public function loadTranslations(string $locale, string $group): array
    {
        if (!empty($this->translations[$locale][$group])){
            return $this->translations[$locale][$group];
        }

        return [];
    }
}
