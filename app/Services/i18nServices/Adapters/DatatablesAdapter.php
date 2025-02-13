<?php

namespace App\Services\i18nServices\Adapters;

use App\Repositories\i18n\i18nKeysRepository;
use App\Repositories\i18n\i18nLanguageRepository;
use App\Repositories\i18n\i18nTranslationRepository;

class DatatablesAdapter
{
    /** @var array */
    protected $data;

    /** @var \Illuminate\Support\Collection */
    protected $languages;

    /** @var i18nLanguageRepository */
    protected $languagesRepository;

    /** @var i18nTranslationRepository */
    protected $translationRepository;

    /** @var i18nKeysRepository */
    protected $keysRepository;

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
        $this->keysRepository = app()->make(i18nKeysRepository::class);

        $this->translations = $this->translationRepository->all();

        $this->prepareData();
    }

    /**
     * Prepare the data for datatables.
     */
    private function prepareData()
    {
        if (!empty($this->data['data'])) {
            foreach($this->data['data'] as &$datum) {
                $datum['module_id'] = (int)$datum['module_id'];
            }
        }
    }

    public function get($additionalQueryData = [])
    {
        $this->additionalQueryData = $additionalQueryData;

        $out = $this->data;
        $out['data'] = $this->processRows();
        $out['recordsTotal'] = $this->processRecordsTotal();
        $out['recordsFiltered'] = $this->processRecordsFiltered();
        return $out;
    }

    protected function getQuery()
    {
        return $this->keysRepository->query()->select('key');
    }

    protected function processRecordsTotal()
    {
        return $this->getQuery()->get()->count();
    }

    protected function processRecordsFiltered()
    {
        $query = $this->getQuery();
        if (!empty($this->additionalQueryData['module_id'])) {
            $query->where('module_id', $this->additionalQueryData['module_id']);
        }

        if (!empty($this->additionalQueryData['show_only_untranslated'])) {
            $query->whereNotIn('i18n_keys.id', function($query) {
                /** @var i18nLanguageRepository $languageRepository */
                $languageRepository = app()->make(i18nLanguageRepository::class);
                $language1 = $languageRepository->query()->where('locale', $this->additionalQueryData['language1'])->first();
                $language2 = $languageRepository->query()->where('locale', $this->additionalQueryData['language2'])->first();
                $query->select('id')->from('i18n_translations')->whereIn('language_id', [$language1->id, $language2->id]);
            });
        }
        return $query->get()->count();
    }

    protected function processRows()
    {
        $data = [];

        $locales = $this->languages->pluck('locale', 'id')->toArray();

        foreach($this->data['data'] as $datum) {
            $d = $datum;
            unset($d['created_at'], $d['updated_at']);

            foreach($locales as $languageId => $locale) {
                $d[$locale] = $this->getTranslation($languageId, $datum['id']);
            }

            $data[] = $d;
        }

        foreach($data as &$datum) {
            foreach($locales as $locale) {
                if (!isset($datum[$locale])) {
                    $datum[$locale] = '';
                }
            }
        }

        return $data;
    }

    protected function getTranslation($languageId, $keyId)
    {
        foreach($this->translations as $translation) {
            if ($translation->language_id == $languageId && $translation->key_id == $keyId) {
                return $translation->translation;
            }
        }
        return '';
    }
}
