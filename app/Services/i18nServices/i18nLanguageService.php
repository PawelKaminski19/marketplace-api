<?php

namespace App\Services\i18nServices;

use App\Models\i18n\i18nLanguage;
use App\Repositories\i18n\i18nLanguageRepository;

class i18nLanguageService extends AbstractService
{
    const DEFAULT_LANGUAGE = 'de';

    public function make(?i18nLanguage $model)
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
            $this->model = new i18nLanguage();
        }

        unset($data['id']);

        $this->model->fill($data);
        $this->model->save();
        $this->model->refresh();

        return $this->model;
    }

    /**
     * Get default language for the application.
     *
     * @return i18nLanguage
     */
    public function getDefaultLanguage()
    {
        /** @var i18nLanguageRepository $repository */
        $repository = app()->make(i18nLanguageRepository::class);
        $lang = $repository->query()->where('locale', self::DEFAULT_LANGUAGE)->first();
        if (!$lang) {
            $lang = $repository->query()->orderBy('id')->first();
        }
        return $lang;
    }

    /**
     * Get all possible languages.
     *
     * @return \Illuminate\Database\Eloquent\Model[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function all()
    {
        /** @var i18nLanguageRepository $repository */
        $repository = app()->make(i18nLanguageRepository::class);
        return $repository->all();
    }

    public function delete()
    {
        // if you need to add something here - please consider using an observer class: App\Observers\i18n\Language
        return parent::delete();
    }
}
