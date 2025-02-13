<?php

namespace App\Services\i18nServices;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

abstract class AbstractService
{
    protected $model;

    /**
     * @var Guard
     */
    protected $guard;

    public function __construct()
    {
        $this->guard = Auth::guard();
    }

    /**
     * Update data.
     *
     * @param array $data
     * @return $this
     */
    public function updateData($data)
    {
        $this->model->fill($data);
        $this->model->save();
        $this->model->refresh();
        return $this;
    }


    /**
     * Delete record.
     *
     * @return bool
     */
    public function delete()
    {
        if ($this->model) {
            $this->model->delete();
            return true;
        }
        return false;
    }
}
