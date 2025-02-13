<?php

namespace App\Services\UserServices;

use App\Models\User;
use App\Repositories\UserRepository;

/**
 * Class UsersService.
 *
 * @package App\Services\UserServices
 */
class UsersService
{

    /**
     * Create a new UsersService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepo = app()->make(UserRepository::class);
    }

    /**
     * Get Users by Client id
     * @param int $clientId
     * @return string
     */
    public function getAllUsersByClientId(int $clientId)
    {
        return $this->userRepo->getAllByClientId($clientId);
    }

    /**
     * Get all users
     *
     * @return string
     */
    public function getAll()
    {
        return $this->userRepo->getAll();
    }

     /**
     * Finds User by id
     *
     * @param int $id
     * @return User
     */
    public function find(int $id)
    {
        return $this->userRepo->find($id);
    }

    /**
     * Update a user
     * @param int $userId
     * @param array $data
     * @return string
     */
    public function update(int $userId, array $data)
    {
        return $this->userRepo->update($userId, $data);
    }
}
