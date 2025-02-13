<?php

namespace App\Services\UserServices;

use App\Exceptions\DashboardNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Models\Affiliate;
use App\Models\Client;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Softwareowner;
use App\Models\User;
use App\Packages\AccountType;
use App\Repositories\UserRepository;

/**
 * Class UsersAccountService.
 * @package App\Services\UserServices
 */
class UsersAccountService
{
    /**
     * Create a new UsersAccountService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userRepo = app()->make(UserRepository::class);
    }

    /**
     * Checking if given user can log to given account
     * @param User $user
     * @param string $accountType
     * @param int $accountId
     *
     * @return bool|UserNotFoundException
     */
    public function checkIfUserCanLogToAccount(User $user, string $accountType, int $accountId)
    {
        if ($user) {
            if (($accountType == AccountType::softwareowner() && $user->softwareowner)) {
                return $user->softwareowner->id === $accountId;
            } elseif (($accountType == AccountType::brand() && $user->brands && count($user->brands) > 0)) {
                return in_array($accountId, $user->brands->pluck('id')->toArray());
            } elseif (($accountType == AccountType::employee() && $user->employees && count($user->employees) > 0)) {
                return in_array($accountId, $user->employees->pluck('id')->toArray());
            } elseif (($accountType == AccountType::customer() && $user->customers && count($user->customers) > 0)) {
                return in_array($accountId, $user->customers->pluck('id')->toArray());
            } elseif (($accountType == AccountType::affiliate() && $user->affiliates && count($user->affiliates) > 0)) {
                return in_array($accountId, $user->affiliates->pluck('id')->toArray());
            } else {
                throw new DashboardNotFoundException("Correct Dashboard Not Found");
            }
        }
        throw new UserNotFoundException("User Not Found");
    }

    /**
     * Setting an logged in account
     * @param User $user
     * @param string $accountType
     * @param int $accountId
     *
     * @return bool|UserNotFoundException
     */
    public function setLoggedInAccount(User $user, string $accountType, int $accountId)
    {
        $accountClassName = AccountType::findClassNameByShortName($accountType);

        if ($accountClassName) {
            $data = [
                'userable_id' => $accountId,
                'userable_type' => $accountClassName,
            ];

            return $this->userRepo->update($user->id, $data);
        }
        throw new UserNotFoundException("User Not Found");
    }

    /**
     * Setting a default account logged in
     * @param User $user
     * @param User $defaultUserChosen
     *
     * @return bool|UserNotFoundException
     */
    public function setDefaultLoggedInAccountByHierarchy(User $user, $defaultUserChosen)
    {
        if ($defaultUserChosen) {
            $data = [
                'userable_id' => $defaultUserChosen->id,
                'userable_type' => get_class($defaultUserChosen),
            ];

            return $this->userRepo->update($user->id, $data);
        }
        throw new UserNotFoundException("User Not Found");
    }
    /**
     * Get Default Logged In Account, according to hierarchy
     * @param User $user
     * @param bool $includeSoftwareowner
     *
     * @return Object|UserNotFoundException|DashboardNotFoundException
     */
    public function getDefaultLoggedInAccountByHierarchy(User $user, bool $includeSoftwareowner = true)
    {
        if ($user) {
            if (($user->softwareowner && $includeSoftwareowner)) {
                return $user->softwareowner;
            }  elseif (($user->brands && count($user->brands) > 0)) {
                return $user->brands->first();
            } elseif (($user->employees && count($user->employees) > 0)) {
                return $user->employees->first();
            } elseif (($user->customers && count($user->customers) > 0)) {
                return $user->customers->first();
            } elseif (($user->affiliates && count($user->affiliates) > 0)) {
                return $user->affiliates->first();
            } else {
                throw new DashboardNotFoundException("Correct Dashboard Not Found");
            }
        }
        throw new UserNotFoundException("User Not Found");
    }

    /**
     * Get a number of accounts assigned to single user
     * @param User $user
     * @param bool $includeSoftwareowner
     *
     * @return int|UserNotFoundException
     */
    public function getNumberOfAccountsAssignedToUser(User $user, bool $includeSoftwareowner = true)
    {
        $i = 0;
        if ($user) {
            foreach (['employees', 'customers', 'affiliates', 'brands'] as $value) {
                if ($user->${"value"}) {
                    $i += count($user->${"value"});
                }
            }
            return ($user->softwareowner && $includeSoftwareowner) ? ++$i : $i;
        }
        throw new UserNotFoundException("User Not Found");
    }

    /**
     * Retrieving a dashboard redirection by User object and hierarchy
     * @param User $user
     *
     * @return string|UserNotFoundException|DashboardNotFoundException
     */
    public function dashboardTypeChecking(User $user)
    {
        if ($user) {
            if (($user->softwareowner)) {
                return AccountType::softwareowner();
            } elseif (($user->employees && count($user->employees) > 0)) {
                return AccountType::brand();
            } elseif (($user->brands && count($user->brands) > 0)) {
                return AccountType::employee();
            } elseif (($user->customers && count($user->customers) > 0)) {
                return AccountType::customer();
            } elseif (($user->affiliates && count($user->affiliates) > 0)) {
                return AccountType::affiliate();
            } else {
                throw new DashboardNotFoundException("Correct Dashboard Not Found");
            }
        }
        throw new UserNotFoundException("User Not Found");
    }

    /**
     * Retrieveing available accounts by user object
     * @param User $user
     *
     * @return array|UserNotFoundException|DashboardNotFoundException
     */
    public function getAccountsByUser(User $user)
    {
        /*
         * @var array
         * */
        $accounts = [];
        if ($user) {
            $accountsFound = false;
            if (($user->softwareowner)) {
                $accounts[AccountType::softwareowner()] = $user->softwareowner;
                $accountsFound = true;
            }
            if (($user->brands && count($user->brands) > 0)) {
                $accounts[AccountType::brand()] = $user->brands;
                $accountsFound = true;
            }
            if (($user->employees && count($user->employees) > 0)) {
                $accounts[AccountType::employee()] = $user->employees;
                $accountsFound = true;
            }
            if (($user->customers && count($user->customers) > 0)) {
                $accounts[AccountType::customer()] = $user->customers;
                $accountsFound = true;
            }
            if (($user->affiliates && count($user->affiliates) > 0)) {
                $accounts[AccountType::affiliate()] = $user->affiliates;
                $accountsFound = true;
            }
            if (!$accountsFound) {
                throw new DashboardNotFoundException("Correct Dashboard Not Found");
            }
            return $accounts;
        }
        throw new UserNotFoundException("User Not Found");
    }

    /**
     * Dashboard redirection
     * @param User $user
     *
     * @return Client|null
     */
    public function getClientByUserAssigned(User $user)
    {
        if ($user) {
            if (($user->softwareowner)) {
                return $user->softwareowner->client;
            } elseif (($user->brand)) {
                return $user->brand->client;
            } elseif (($user->customer)) {
                return $user->customer->client;
            } elseif (($user->employee)) {
                return $user->employee->client;
            }
        }
        return null;
    }

    /**
     * Choose the account for the user to log in
     * @param User $user
     * @param string $accountType
     * @param int $accountId
     * @param bool $searchOnlySpecificAccounts
     *
     * @return bool
     */
    public function chooseAccount(User $user, string $accountType, int $accountId)
    {
        if ($accountType == 'clients' && $user && $user->employees && count($user->employees) > 0) {
            foreach ($user->employees as $employee) {
                if ($employee->client && $employee->client->id == $accountId) {
                    return true;
                }
            }
        } elseif (in_array($accountType, AccountType::all()) && $this->checkIfUserCanLogToAccount(auth()->user(), $accountType, $accountId)) {
            $this->setLoggedInAccount(auth()->user(), $accountType, $accountId);
            return true;
        }
        return false;
    }

    /**
     * Checking if user is a softwareowner of the given client
     * @param User $user
     * @param Client $client
     *
     * @return bool
     */
    public function checkIfUserIsSoftwareowner(User $user, int $clientId)
    {
        if ($user->softwareowner && $user->softwareowner->client) {
            if ($user->softwareowner->client->id == $clientId || $user->softwareowner->client->softwareowner_flag == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checking if a user is a system owner (Jacek)
     * @param User $user
     *
     * @return bool
     */
    public function checkIfUserIsSystemowner(User $user)
    {
        if ($user->softwareowner && $user->softwareowner->client) {
            if ($user->softwareowner->client->softwareowner_flag == 1) {
                return true;
            }
        }
    }

    /**
     * Checking if user has a permission by client id
     * this is a MAIN function which checks permission
     * @param User $user
     *
     * @return bool
     */
    public function checkIfUserHasPermissionByClientId(User $user, int $clientId, string $permission)
    { 
        if (!empty($user->userable->assignedClients()) && in_array($clientId,$user->userable->assignedClients()->pluck('id')->toArray())) {
            // firstly let's collect all of the roles  assigned to the given user and assigned to particular client (same user can't have different roles related to different clients!)
            // so we're grabbing the user->client roles match
            $roles = $user->roles->where('client_id', $clientId);

            // for each role assigned to user and client, let's check if the needed permission is available
            foreach ($roles as $role) {
                if ($role->hasPermissionTo($permission)) {
                    return true;
                }
            }

            // now let's check the global (core) roles. There roles aren't assigned to particular client
            $coreRoles = $user->roles->where('client_id', null);

            foreach ($coreRoles as $role) {
                if ($role->hasPermissionTo($permission)) {
                    return true;
                }
            }
            return false;
        }

        //do the same thing for onBehalfLogin -> it means logged in as a client
        if (($user->onbehalf && $user->onbehalf->client && $user->onbehalf->client->id == $clientId) || ($user->onbehalf && $user->onbehalf->id && $user->onbehalf->id == $clientId)) {
            return true;
        }

        //do the same thing for onBehalfLogin -> it means logged in as a customer
        if (($user->onbehalf && $user->onbehalf->customer && $user->onbehalf->customer->client->id == $clientId) || ($user->onbehalf && $user->onbehalf->id && $user->onbehalf->id == $clientId)) {
            return true;
        }

        return false;
    }
}
