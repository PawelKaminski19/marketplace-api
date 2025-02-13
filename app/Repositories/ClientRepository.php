<?php

namespace App\Repositories;

use App\Models\Client;

/**
 * Class ClientRepository.
 *
 * @package App\Repository
 */
class ClientRepository extends BaseRepository
{
    /**
     * Initialize clients repository instance.
     *
     * @param Client $model
     */
    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    /**
     * Get by clients slug.
     *
     * @param int $name
     *
     * @return Model
     */
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Assign Client to Brand
     *
     * @param int $clientId
     * @param int $brandId
     * @return string
     */
    public function assignToBrand(int $clientId, int $brandId)
    {
        $client = $this->model->find($clientId);

        if ($client) {
            $client->brands()->attach($brandId);
            if ($client->brands()->where('brand_id', '=', $brandId)->first()) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    /**
     * Get softwareowner domain
     *
     * @return Model
     */
    public function getSoftwareOwner()
    {
        $domainObj = $this->model->where('softwareowner_flag', 1)->first();
        return $domainObj ?? null;
    }

     /**
     * Get all.
     *
     * @return Model[]|Collection
     */
    public function getAll($paginate = false)
    {
        return $this->model->with('employees','employees.usersAssigned','customers','websites','websites.domains')->get();
    }


     /**
     * Get by id.
     *
     * @param int $clientId
     * @return Model[]|Collection
     */
    public function find($clientId, $orFaile = true)
    {
        return $this->model->with('employees','employees.usersAssigned','customers','websites','websites.domains')->find($clientId);
    }


    /**
    * Get by list of ids.
    *
    * @param int $clientId
    * @return Model[]|Collection
    */
   public function findByMultipleIds($clients)
   {
       return $this->model->with('employees','employees.usersAssigned','customers','websites','websites.domains')->whereIn('id',$clients)->get();
   }
    
}
