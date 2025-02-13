<?php

namespace App\Services\UserServices;

use App\Exceptions\ClientNotFoundException;
use App\Models\Customer;
use App\Models\Softwareowner;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;

/**
 * Class UsersOnBehalfService.
 * @package App\Services\UserServices
 */
class UsersOnBehalfService
{
    /**
     * Create a new UsersOnBehalfService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepo = app()->make(UserRepository::class);
        $this->clientRepo = app()->make(ClientRepository::class);
        $this->customerRepo = app()->make(CustomerRepository::class);
    }

    /**
     * Setting a default account logged in
     * @param User $user
     * @param string $onBehalfType
     * @param int $onBehalfId
     *
     * @return bool|ClientNotFoundException
     */
    public function setOnBehalfEntity(User $user, string $onBehalfType, int $onBehalfId)
    {
        try {
            if ($onBehalfType === 'client') {
                $onBehalfClassName = "App\Models\Client";
                $found = $this->clientRepo->find($onBehalfId);
            } elseif ($onBehalfType === 'customer') {
                $onBehalfClassName = "App\Models\Customer";
                $found = $this->customerRepo->find($onBehalfId);
            }
        } catch (\Exception $e) {
            $found = false;
            throw new ClientNotFoundException(ucfirst($onBehalfType) . " Not Found");
        }
        if ($onBehalfClassName && $found) {
            $data = [
                'onbehalf_id' => $onBehalfId,
                'onbehalf_type' => $onBehalfClassName,
                'onbehalf_time' => \Carbon\Carbon::now(),
            ];

            return $this->userRepo->update($user->id, $data);
        }
        throw new ClientNotFoundException("Client Not Found");
    }

    /**
     * Checking if user can log in as software owner
     * @param User $user
     * @param int $clientId
     *
     * @return bool
     */
    public function canUserLoginOnBehalf(User $user, int $clientId)
    {
        if ($user->softwareowner && $user->softwareowner->client) {
            // checking if the user is a software owner for the client OR is a system owner
            if ($user->softwareowner->client->id == $clientId || $user->softwareowner->client->softwareowner_flag == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checking if user can log in as customer
     * @param User $user
     * @param int $clientId
     *
     * @return bool
     */
    public function canUserLoginOnBehalfCustomer(User $user, int $clientId)
    {
        if (isset($user->softwareowner->client->softwareowner_flag) && $user->softwareowner->client->softwareowner_flag == 1) {
            return true;
        }
        $loginAsCustomer = false;

        foreach ($user->employees as $employee) {
            if ($employee->client && $employee->client->id = $clientId) {
                $loginAsCustomer = true;
                break;
            }
        }
        return $loginAsCustomer;
    }

    /**
     * Log out from on behalf feature
     * @param int $userId
     * @return bool
     */
    public function logoutOnBehalf(int $userId)
    {
        return $this->userRepo->update($userId, ['onbehalf_type' => null,
            'onbehalf_time' => null,
            'onbehalf_id' => null]);
    }
}
