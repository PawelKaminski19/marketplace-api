<?php

namespace App\Repositories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EmployeeRepository.
 *
 * @package App\Repository
 */
class WebsiteRepository extends BaseRepository
{
    /**
     * Initialize Website repository instance.
     *
     * @param Website $model
     */
    public function __construct(Website $model)
    {
        $this->model = $model;
    }

    /**
     * Get brands by websiteId.
     *
     * @param int $websiteId
     * @return Collection
     */
    public function getBrands($websiteId)
    {
        /** @var Website $website */
        $website = $this->find($websiteId);
        return $website->brands;
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
        return $this->model->with('domains')->find($id);
    }

    /**

     * Get by id and client.
     *
     * @param int $id
     * @param int $clientId
     *
     * @return Model
     */
    public function findByClient(int $id, int $clientId)
    {
        return $this->model->where('client_id', $clientId)->with('domains')->find($id);
    }
    
    /**
     * Get shop by slug.
     *
     * @param string $slug
     * @return Model
     */
    public function getShopBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();

    }
}
