<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserServices\UsersAccountService;

/* This is the most important authorization code 
   it checks if the user is the system owner 
   or if the user has permission to the client id provider in request
   or if the user has a particular permission to client assigned to him */
class BaseFormProtectedRequest extends FormRequest
{
    protected $permission;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {  
        if (null === auth()->user()) {
            return false;
        }
        /** @var UsersAccountService */
        $usersAccountService = app()->make(UsersAccountService::class);
        
        /** @var int $clientId */
        $clientId = $this->route()->parameter('clientId') ? $this->route()->parameter('clientId') : false;
       
        //checking if user is a system owner
        if ($usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            return true;
        //now checking if the client id is provided in the parameters
        } else if ($clientId && !empty($this->permission)) {
            if ($usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, $this->permission) || $usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId)) {
                return true;
            }
        //finally check the clients assigned to the user
        } else if (auth()->user()->userable && !empty(auth()->user()->userable->assignedClients())) {
            $clients = auth()->user()->userable->assignedClients();
           
            foreach ($clients as $client) { 
                if (!$usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $client->id, $this->permission) && !$usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $client->id)) {
                     return false;
                }
            }
            return true;
        } 
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
