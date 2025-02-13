<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepo.
 *
 * @package App\Repository
 */
abstract class BaseRepository
{
    /**
     * @var Model|mixed
     */
    protected $model;

    /** Just for compatibility with i18n code. it can be extended freely. */
    public function __construct()
    {
    }

    /**
     * Get all.
     *
     * @return Model[]|Collection
     */
    public function getAll($paginate = false)
    {  
        return $paginate ? $this->model->paginate() : $this->model->all();
    }

    /**
     * Shortcut for getAll()
     *
     * @return Model[]|Collection
     */
    public function all()
    {
        return $this->getAll();
    }

    /**
     * Get by id.
     *
     * @param int $id
     * @param bool $orFail
     *
     * @return Model
     */
    public function find($id, $orFail = true)
    {
        if ($orFail) {
            return $this->model->findOrFail($id);
        }

        return $this->model->find($id);
    }

    /**
     * Create.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update.
     *
     * @param int $id
     * @param array $data
     *
     * @return bool|int
     */
    public function update($id, array $data)
    {
        /** @var Model $object */
        $object = $this->model->find($id);

        if (is_null($object)) {
            return false;
        }

        return $object->update($data) ? $object : false;
    }

    /**
     * Delete.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Return an instance to the sql builder object.
     *
     * @return Builder
     */
    public function query()
    {
        return $this->model->newQuery();
    }
}
