<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserServices\UsersAccountService;


class BaseFormForSoOnly extends FormRequest
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
       
        //checking if user is a system owner
        if ($usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
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
