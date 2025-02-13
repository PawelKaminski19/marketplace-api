<?php
namespace App\Http\Resources\UsersRolesAndPermissions;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMeAllDataResource extends JsonResource
{

    /**
     * @var Collection
     */
    protected $data;

    /**
     * @var bool
     */
    protected $includePossibleAccounts;

    /**
     * UserLoggedInResource Constructor
     */
    public function __construct()
    {
        parent::__construct(collect());
        $this->includePossibleAccounts = false;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setIncludePossibleAccounts(bool $value)
    {
        $this->includePossibleAccounts = $value;
    }
    /**
     * Preparing data, removing unnecessary fields
     */
    private function prepareData()
    {
        $result = $this->data->toArray();
        if ($this->data->softwareowner && $this->includePossibleAccounts) {
            $result['softwareowner'] = $this->data->softwareowner->toArray();
            if ($this->data->softwareowner->client) {
                $result['softwareowner']['client'] = $this->data->softwareowner->client;
            }
            if ($this->data->softwareowner->lang) {
                $result['softwareowner']['lang'] = $this->data->softwareowner->lang;
            }
        }
        $resultsAccounts = [];

        if ($this->data->employees && $this->includePossibleAccounts) {
            $resultsAccounts['employees'] = $this->data->employees->map(function ($employee, $key) {
                $aTemporary = $employee->toArray();
                $aTemporary['gender'] = $employee->gender;
                $aTemporary['lang'] = $employee->lang;
                $aTemporary['client'] = $employee->client;
                return $aTemporary;
            });
        }

        if ($this->data->customers && $this->includePossibleAccounts) {
            $resultsAccounts['customers'] = $this->data->customers->map(function ($customer, $key) {
                $aTemporary = $customer->toArray();
                $aTemporary['gender'] = $customer->gender;
                $aTemporary['lang'] = $customer->lang;
                $aTemporary['client'] = $customer->client;
                $aTemporary['website'] = $customer->website;
                $aTemporary['group'] = $customer->group;
                return $aTemporary;
            });
        }

        if ($this->data->affiliates && $this->includePossibleAccounts) {
            $resultsAccounts['affiliates'] = $this->data->affiliates->map(function ($affiliate, $key) {
                $aTemporary = $affiliate->toArray();
                $aTemporary['gender'] = $affiliate->gender;
                $aTemporary['lang'] = $affiliate->lang;
                $aTemporary['clients'] = $affiliate->clients;
                return $aTemporary;
            });
        }

        if (count($resultsAccounts) > 0) {
            $result['accounts'] = $resultsAccounts;
        }

        if ($this->data->userable) {
            $accountName = strtolower(substr(strrchr(get_class($this->data->userable), "\\"), 1));
            $result["logged_in_account"][$accountName] = $this->data->userable;
            if ($this->data->userable->client) {
                $result["logged_in_account"][$accountName]['client'] = $this->data->userable->client;
            }
            if ($this->data->userable->lang) {
                $result["logged_in_account"][$accountName]['lang'] = $this->data->userable->lang;
            }
            if ($this->data->userable->gender) {
                $result["logged_in_account"][$accountName]['gender'] = $this->data->userable->gender;
            }
        }
        return $result;
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
