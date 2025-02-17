<?php

namespace App\Repositories\i18n;

use App\Models\i18n\i18nKey;
use App\Repositories\BaseRepository;

class i18nKeysRepository extends BaseRepository
{
    protected $additionalData;

    public function __construct(i18nKey $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function setAdditionalQueryData($data)
    {
        $this->additionalData = $data;
        return $this;
    }

    public function all($columns = ['*'])
    {
        return $this->allQuery()->get();
    }

    public function allQuery()
    {
        $query = $this->query()->orderBy('key', 'asc');
        if (!empty($this->additionalData['module_id'])) {
            $query->where('module_id', $this->additionalData['module_id']);
        }

        if (!empty($this->additionalData['show_only_untranslated'])) {
            $query->whereNotIn('i18n_keys.id', function($query) {
                /** @var i18nLanguageRepository $languageRepository */
                $languageRepository = app()->make(i18nLanguageRepository::class);
                $language1 = $languageRepository->query()->where('locale', $this->additionalData['language1'])->first();
                $language2 = $languageRepository->query()->where('locale', $this->additionalData['language2'])->first();
                $query->select('id')->from('i18n_translations')->whereIn('language_id', [$language1->id, $language2->id]);
            });
        }

        return $query->join('i18n_modules', 'i18n_modules.id', '=', 'i18n_keys.module_id')
            ->select(['i18n_keys.*', 'i18n_modules.name AS module_name']);
    }

    public function isKeyExist($params)
    {
        $query = $this->query()->where('key', $params['key'])->where('module_id', $params['moduleId']);
        if (!empty($params['ignoreId'])) {
            $query->where('id', '<>', $params['ignoreId']);
        }
        return (bool)$query->first();
    }
}
