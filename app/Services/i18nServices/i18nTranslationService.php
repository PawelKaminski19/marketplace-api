<?php

namespace App\Services\i18nServices;

use App\Models\i18n\i18nTranslation;
use App\Repositories\i18n\i18nKeysRepository;
use App\Repositories\i18n\i18nLanguageRepository;
use App\Repositories\i18n\i18nTranslationRepository;
use App\Services\i18nServices\AbstractService;
use App\Services\i18nServices\Adapters\Vuei18nAdapter;
use Cache;

class i18nTranslationService extends AbstractService
{
    const TRANSLATION_KEY = 'translation';

    public function make(i18nTranslation $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Save model.
     *
     * @param array $data
     * @return bool
     */
    public function save($data)
    {
        if (!$this->model) {
            $this->model = new i18nTranslation();
        }

        unset($data['id']);

        $this->model->fill($data);
        $this->model->save();
        $this->model->refresh();

        return $this->model;
    }

    /**
     * Set the translation.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setTranslation($data)
    {
        /** @var i18nLanguageRepository $repositoryLanguages */
        $repositoryLanguages = app()->make(i18nLanguageRepository::class);

        /** @var i18nTranslationRepository $repositoryTranslations */
        $repositoryTranslations = app()->make(i18nTranslationRepository::class);

        /** @var i18nKeysRepository $repositoryKeys */
        $repositoryKeys = app()->make(i18nKeysRepository::class);
        $key = $repositoryKeys->query()->where('key', $data['key'])->where('module_id', $data['module_id'])->first();
        if (!$key) {
            throw new \Exception('A key named "'.$data['key'].'" should be defined first.');
        }

        $language = $repositoryLanguages->query()->where('locale', $data['locale'])->first();
        $translation = $repositoryTranslations->query()->where('key_id', $key->id)->where('language_id', $language->id)->first();
        if (!$translation) {
            // get module by other key
            $translation = $repositoryTranslations->create([
                'language_id' => $language->id,
                'key_id' => $key->id,
                'translation' => $data['translation']
            ]);
            return $translation;
        }
        $translation->translation = $data['translation'];
        $translation->save();
        return $translation;
    }

    /**
     * Change key name.
     *
     * @param array $data
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function changeKey($data)
    {
        $repositoryKeys = app()->make(i18nKeysRepository::class);
        $row = $repositoryKeys->query()->where('key', $data['oldKey'])->where('module_id', $data['module_id'])->first();
        $row->key = $data['newKey'];
        return $row->save();
    }

    /**
     * Get translations for all the site using default Vue adapter.
     *
     * @param bool $forceRebuild
     * @param string $language
     * @param array $modules If empty - return all modules.
     * @return mixed
     */
    public function getSiteTranslations($forceRebuild = false, $language = '', $modules = [])
    {
        if ($forceRebuild || !Cache::store('file')->has(self::TRANSLATION_KEY)) {
            $this->rebuildCache();
        }

        $data = Cache::store('file')->get(self::TRANSLATION_KEY);

        if ($language && isset($data[$language])) {
            $data = $data[$language];
        }

        if ($modules) {
            $data = array_filter($data, function ($module) use ($modules) {
                return in_array($module, $modules);
            }, ARRAY_FILTER_USE_KEY);
        }

        return $data;
    }

    /**
     * Rebuild the translation cache.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rebuildCache()
    {
        $repository = app()->make(i18nTranslationRepository::class);
        Cache::store('file')->forget(self::TRANSLATION_KEY);
        Cache::store('file')->forever(self::TRANSLATION_KEY, (new Vuei18nAdapter($repository->all()))->get());
    }
}
