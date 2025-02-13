<?php

namespace App\Services\i18nServices;

use App\Models\i18n\i18nModule;
use App\Repositories\i18n\i18nModuleRepository;

class i18nModuleService extends AbstractService
{
    public function make(i18nModule $model)
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
            $this->model = new i18nModule();
        }

        unset($data['id']);

        $this->model->fill($data);
        $this->model->save();
        $this->model->refresh();

        return $this->model;
    }

    public function saveRaw($data)
    {
        $idsToKeep = [];
        /** @var i18nModuleRepository $repository */
        $repository = app()->make(i18nModuleRepository::class);

        foreach($data as $datum) {
            $row = empty($datum['id']) ? $repository->create(['name' => $datum['name']]) : $repository->find($datum['id']);
            $row->name = $datum['name'];
            $row->save();

            $idsToKeep[] = $row->id;
        }

        if ($idsToKeep) {
            $repository->query()->whereNotIn('id', $idsToKeep)->delete();
        }
        else {
            $repository->query()->delete();
        }

        return $repository->all();
    }
}
