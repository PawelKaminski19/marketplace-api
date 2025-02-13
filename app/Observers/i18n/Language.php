<?php

namespace App\Observers\i18n;

use App\Models\i18n\i18nLanguage;
use App\Repositories\i18n\i18nTranslationRepository;
use App\Services\i18nServices\Exceptions\i18nLanguageCantBeDeleted;
use App\Services\i18nServices\Exceptions\i18nNoDefaultLanguage;
use App\Services\i18nServices\i18nLanguageService;

class Language
{
    protected $fields = [
        'customers' => ['lang_id'],
        'affiliates' => ['lang_id'],
        'employees' => ['lang_id'],
        'softwareowners' => ['lang_id'],
        'guests' => ['lang_id']
    ];

    /**
     * Process event right before record is being deleted.
     *
     * @param i18nLanguage $language
     */
    public function deleting(i18nLanguage $language)
    {
        // check if this is the last language. if yes - throw an exception
        /** @var $repository i18nTranslationRepository */
        $repository = app()->make(i18nTranslationRepository::class);
        if ($repository->query()->count() <= 1) {
            throw new i18nLanguageCantBeDeleted('At least one language needs to be present in the system.');
        }

        $defaultLanguage = $this->getDefaultLanguage();
        if ($defaultLanguage) {
            // change default language for all tables.
            foreach($this->fields as $table => $fields) {
                $pairs = $this->getKVPairs($fields, $defaultLanguage);
                $query = \DB::table($table);
                foreach($pairs as $fieldName => $value) {
                    $query->orWhere($fieldName, $language->id);
                }
                $query->update($pairs);
            }
        }
        else {
            throw new i18nNoDefaultLanguage('No default language has been provided.');
        }
    }

    /**
     * Get KV pairs by formula: [field1 => id, field2 => id]
     *
     * @param array $fields
     * @param i18nLanguage $i18nLanguage
     * @return array
     */
    protected function getKVPairs($fields, $i18nLanguage)
    {
        $out = [];
        foreach($fields as $field)
        {
            $out[$field] = $i18nLanguage->id;
        }
        return $out;
    }

    /**
     * Get default language for the system.
     *
     * @return \App\Models\i18n\i18nLanguage
     */
    protected function getDefaultLanguage()
    {
        return (new i18nLanguageService())->getDefaultLanguage();
    }
}
