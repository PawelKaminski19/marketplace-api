<?php

namespace App\Repositories;

use App\Models\Affiliate;
use App\Models\User;
use App\Models\Customer;
use App\Models\Softwareowner;
use App\Models\Employee;

/**
 * Class UserRepository.
 *
 * @package App\Repository
 */
class UserRepository extends BaseRepository
{
    /**
     * Initialize user repository instance.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get Users by Client
     *
     * @param int $clientId
     * @return mixed
     */
    public function getAllByClientId(int $clientId)
    {
        $users = $this->model->with('affiliates', 'affiliates', 'customers', 'customers', 'employees', 'employees', 'softwareowner')
        ->whereHas('affiliates', function ($query) use ($clientId) {
            $query->whereHas('clients', function ($query) use ($clientId) {
                $query->where('id', $clientId);
            });
        })->orwhereHas('customers', function ($query) use ($clientId) {
            $query->whereHas('client', function ($query) use ($clientId) {
                $query->where('id', $clientId);
            });
        })->orwhereHas('employees', function ($query) use ($clientId) {
            $query->whereHas('client', function ($query) use ($clientId) {
                $query->where('id', $clientId);
            });
        })->orwhereHas('softwareowner', function ($query) use ($clientId) {
            $query->whereHas('client', function ($query) use ($clientId) {
                $query->where('id', $clientId);
            });
        });


        return $users->get();
    }

    /**
     * Get Users by Client and website
     *
     * @param int $clientId
     * @param int $websiteId
     * @return mixed
     */
    public function findByEmailAndWebsite(string $email,int $websiteId)
    {
        $users = $this->model->where('email',$email)->with('customers')
        ->whereHas('customers', function ($query) use ($websiteId) {
            $query->whereHas('website', function ($query) use ($websiteId) {
                $query->where('id', $websiteId);
            });
        });

        return $users->first();
    }
}
