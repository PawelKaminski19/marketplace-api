<?php

namespace App\Http\Requests\UsersRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormProtectedRequest;

class GetWebsitesRequest extends BaseFormProtectedRequest
{
    protected $permission = 'read user';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required|integer'
        ];
    }
}
