<?php
namespace App\Http\Resources\UsersRolesAndPermissions;

use App\Packages\AccountType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserLoggedInWithAccountsResource extends ResourceCollection
{

    /**
     * @var Collection
     */
    protected $data;

    /**
     * UserLoggedInWithAccountsResource Constructor
     */
    public function __construct()
    {
        parent::__construct(collect());
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Preparing data, removing unnecessary fields
     */
    private function prepareData(): array
    {
        $accounts = isset($this->data['accounts']) ? $this->data['accounts'] : null;

        $resultsAccounts = [];

        if (isset($accounts[AccountType::softwareowner()])) {
            $resultsAccounts['softwareowner'] = $accounts[AccountType::softwareowner()]->toArray();
            $resultsAccounts['softwareowner']['lang'] = $accounts[AccountType::softwareowner()]->lang;
            $resultsAccounts['softwareowner']['client'] = $accounts[AccountType::softwareowner()]->client;
        }
        if (isset($accounts[AccountType::brand()]) && count($accounts[AccountType::brand()]) > 0) {
            $resultsAccounts['brands'] = $accounts[AccountType::brand()]->map(function ($brand, $key) {
                $aTemporary = $brand->toArray();
                $aTemporary['gender'] = $brand->gender;
                $aTemporary['lang'] = $brand->lang;
                $aTemporary['client'] = $brand->client;
                return $aTemporary;
            });
        }

        if (isset($accounts[AccountType::employee()]) && count($accounts[AccountType::employee()]) > 0) {
            $resultsAccounts['employees'] = $accounts[AccountType::employee()]->map(function ($employee, $key) {
                $aTemporary = $employee->toArray();
                $aTemporary['gender'] = $employee->gender;
                $aTemporary['lang'] = $employee->lang;
                $aTemporary['client'] = $employee->client;
                return $aTemporary;
            });
        }
        if (isset($accounts[AccountType::customer()]) && count($accounts[AccountType::customer()]) > 0) {
            $resultsAccounts['customers'] = $accounts[AccountType::customer()]->map(function ($customer, $key) {
                $aTemporary = $customer->toArray();
                $aTemporary['gender'] = $customer->gender;
                $aTemporary['lang'] = $customer->lang;
                $aTemporary['client'] = $customer->client;
                $aTemporary['website'] = $customer->website;
                $aTemporary['group'] = $customer->group;
                return $aTemporary;
            });
        }

        if (isset($accounts[AccountType::affiliate()]) && count($accounts[AccountType::affiliate()]) > 0) {
            $resultsAccounts['affiliates'] = $accounts[AccountType::affiliate()]->map(function ($affiliate, $key) {
                $aTemporary = $affiliate->toArray();
                $aTemporary['gender'] = $affiliate->gender;
                $aTemporary['lang'] = $affiliate->lang;
                $aTemporary['clients'] = $affiliate->clients;
                unset($aTemporary['pivot']);
                return $aTemporary;
            });
        }
        if (count($resultsAccounts) > 0) {
            $this->data['accounts'] = $resultsAccounts;
        }

        return $this->data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return
        $this->prepareData();
    }
}
