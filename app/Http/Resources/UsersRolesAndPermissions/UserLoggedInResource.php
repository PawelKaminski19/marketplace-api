<?php
namespace App\Http\Resources\UsersRolesAndPermissions;

use App\Packages\AccountType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;

class UserLoggedInResource extends ResourceCollection
{

    /**
     * @var Collection
     */
    protected $data;

    /**
     * UserLoggedInResource Constructor
     */
    public function __construct()
    {
        parent::__construct(collect());
    }

    public function setData(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Preparing data, removing unnecessary fields, adding related informations
     */
    private function prepareData(): array
    {
        $result = $this->user->toArray();
        if ($this->user->userable) {
            $accountName = strtolower(substr(strrchr(get_class($this->user->userable), "\\"), 1));
            $result["logged_in_account"][$accountName] = $this->user->userable;
            if ($this->user->userable->clients) {
                $result["logged_in_account"][$accountName]['clients'] = $this->user->userable->clients;
            }
            if ($this->user->userable->client) {
                $result["logged_in_account"][$accountName]['client'] = $this->user->userable->client;
                // TODO: refactor this.
                $result["logged_in_account"][$accountName]['client']['websites'] = $this->user->userable->client->websites;
            }
            if ($this->user->userable->lang) {
                $result["logged_in_account"][$accountName]['lang'] = $this->user->userable->lang;
            }
            if ($this->user->userable->gender) {
                $result["logged_in_account"][$accountName]['gender'] = $this->user->userable->gender;
            }

        }
        return (count($result)>0) ? array_merge($this->data, $result) : $this->data;
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
