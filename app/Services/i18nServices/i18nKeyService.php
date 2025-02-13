<?php

namespace App\Services\i18nServices;

use App\Models\i18n\i18nKey;

class i18nKeyService extends AbstractService
{
    public function make($model)
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
            $this->model = new i18nKey();
        }

        unset($data['id']);

        $this->model->fill($data);
        $this->model->save();
        $this->model->refresh();

        return $this->model;
    }
}
