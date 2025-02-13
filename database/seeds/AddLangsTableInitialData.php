<?php

use Illuminate\Database\Seeder;

class AddLangsTableInitialData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setupLanguages();
        $this->setupModules();
        $this->setupKeys();
        $this->setupTranslations();
    }

    public function setupTranslations()
    {
        \App\Models\i18n\i18nTranslation::unguard();

        $data = [
            [
                'language_id' => 1,
                'key_id' => 1,
                'translation' => 'Einreichen'
            ],
            [
                'language_id' => 2,
                'key_id' => 1,
                'translation' => 'Submit'
            ],

            [
                'language_id' => 1,
                'key_id' => 2,
                'translation' => 'Ausloggen'
            ],
            [
                'language_id' => 2,
                'key_id' => 2,
                'translation' => 'Logout'
            ],

            [
                'language_id' => 1,
                'key_id' => 3,
                'translation' => 'Instrumententafel'
            ],
            [
                'language_id' => 2,
                'key_id' => 3,
                'translation' => 'Dashboard'
            ],

            [
                'language_id' => 1,
                'key_id' => 4,
                'translation' => 'Übersetzungen'
            ],
            [
                'language_id' => 2,
                'key_id' => 4,
                'translation' => 'Translations'
            ],

            [
                'language_id' => 1,
                'key_id' => 5,
                'translation' => 'EINLOGGEN'
            ],
            [
                'language_id' => 2,
                'key_id' => 5,
                'translation' => 'SIGN IN'
            ],

            [
                'language_id' => 1,
                'key_id' => 6,
                'translation' => 'brands'
            ],
            [
                'language_id' => 2,
                'key_id' => 6,
                'translation' => 'brands'
            ],

            [
                'language_id' => 1,
                'key_id' => 7,
                'translation' => 'brand'
            ],
            [
                'language_id' => 2,
                'key_id' => 7,
                'translation' => 'brand'
            ],

            [
                'language_id' => 1,
                'key_id' => 8,
                'translation' => 'shop'
            ],
            [
                'language_id' => 2,
                'key_id' => 8,
                'translation' => 'shop'
            ],

            [
                'language_id' => 1,
                'key_id' => 9,
                'translation' => 'shops'
            ],
            [
                'language_id' => 2,
                'key_id' => 9,
                'translation' => 'shops'
            ],

        ];

        if (\App\Models\i18n\i18nTranslation::count() < 2) {
            foreach($data as $datum) {
                \App\Models\i18n\i18nTranslation::create($datum);
            }
        }
    }

    public function setupKeys()
    {
        \App\Models\i18n\i18nKey::unguard();

        $data = [
            [
                'id' => 1,
                'module_id' => 1,
                'key' => 'submit',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 2,
                'module_id' => 1,
                'key' => 'logout',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 3,
                'module_id' => 3,
                'key' => 'dashboard',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 4,
                'module_id' => 3,
                'key' => 'translations',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 5,
                'module_id' => 1,
                'key' => 'signin',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 6,
                'module_id' => 4,
                'key' => 'brands',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 7,
                'module_id' => 4,
                'key' => 'brand',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 8,
                'module_id' => 4,
                'key' => 'shop',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
            [
                'id' => 9,
                'module_id' => 4,
                'key' => 'shops',
                'type' => \App\Models\i18n\i18nKey::TYPE_SIMPLE
            ],
        ];

        if (\App\Models\i18n\i18nKey::count() < 1) {
            foreach($data as $datum) {
                \App\Models\i18n\i18nKey::create($datum);
            }
        }
    }

    private function setupModules()
    {
        \App\Models\i18n\i18nModule::unguard();

        $data = [
            [
                'id' => 1,
                'name' => 'global'
            ],
            [
                'id' => 2,
                'name' => 'translations'
            ],
            [
                'id' => 3,
                'name' => 'modules'
            ],
            [
                'id' => 4,
                'name' => 'urls'
            ],
        ];

        if (\App\Models\i18n\i18nModule::count() < 1) {
            foreach($data as $datum) {
                \App\Models\i18n\i18nModule::create($datum);
            }
        }
    }

    private function setupLanguages()
    {
        \App\Models\i18n\i18nLanguage::unguard();

        $data = [
            [
                'id' => 1,
                'name' => 'Deutsch',
                'locale' => 'de',
                'sign' => 'DE',
                'active' => 1,
                'language_code' => 'de-de',
                'date_format_lite' => 'd.m.Y',
                'date_format_full' => 'd.m.Y H:i:s',
                'is_rtl' => 0,
            ],
            [
                'id' => 2,
                'name' => 'English',
                'locale' => 'en',
                'sign' => 'EN',
                'active' => 1,
                'language_code' => 'en-en',
                'date_format_lite' => 'Y.m.d',
                'date_format_full' => 'Y.m.d H:i:s',
                'is_rtl' => 0,
            ],
            [
                'id' => 14,
                'name' => 'Polski',
                'locale' => 'pl',
                'sign' => 'PL',
                'active' => 1,
                'language_code' => 'pl-pl',
                'date_format_lite' => 'Y.m.d',
                'date_format_full' => 'Y.m.d H:i:s',
                'is_rtl' => 0,
            ]
        ];

        if (\App\Models\i18n\i18nLanguage::count() < 2) {
            foreach($data as $datum) {
                \App\Models\i18n\i18nLanguage::create($datum);
            }
        }
    }

}
