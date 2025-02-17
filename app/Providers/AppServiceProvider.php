<?php

namespace App\Providers;

use App\Models\i18n\i18nKey;
use App\Models\i18n\i18nLanguage;
use App\Models\i18n\i18nModule;
use App\Models\i18n\i18nTranslation;
use App\Observers\i18n\Key;
use App\Observers\i18n\Language;
use App\Observers\i18n\Module;
use App\Observers\i18n\Translation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Twilio\Service::class,
            \App\Services\Twilio\Verification::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        i18nLanguage::observe(Language::class);
        i18nKey::observe(Key::class);
        i18nTranslation::observe(Translation::class);
        i18nModule::observe(Module::class);
    }
}
