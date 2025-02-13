<?php

namespace App\Services\i18nServices\Adapters;

use App\Models\i18n\i18nLanguage;
use App\Models\i18n\i18nTranslation;
use App\Repositories\i18n\i18nLanguageRepository;
use App\Repositories\i18n\i18nTranslationRepository;
use Arr;

class Vuei18nAdapter
{
    /** @var array */
    protected $data;

    /** @var \Illuminate\Support\Collection */
    protected $languages;

    /** @var i18nLanguageRepository */
    protected $languagesRepository;

    /** @var i18nTranslationRepository */
    protected $translationRepository;

    /** @var array */
    protected $additionalQueryData;

    /** @var array */
    protected $translations;

    public function __construct($data)
    {
        $this->data = $data;

        /** @var i18nLanguageRepository $languagesRepository */
        $this->languagesRepository = app()->make(i18nLanguageRepository::class);
        $this->languages = $this->languagesRepository->all();

        $this->translationRepository = app()->make(i18nTranslationRepository::class);
        $this->translations = $this->translationRepository->all();
    }

    public function get()
    {
        $out = [];

        $this->languages->each(function(i18nLanguage $element) use (&$out) {
            $out[$element->id] = [];
        });

        $this->data->each(function(i18nTranslation $element) use (&$out) {
            Arr::set($out[$element->language_id], $element->key->module->name.'.'.$element->key->key, $element->translation);
        });

        $final = [];

        foreach($out as $languageId => $item) {
            $final[$this->languages->where('id', $languageId)->first()->locale] = $item;
        }

        unset($out);

        return $final;
    }
}
