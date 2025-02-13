<?php

namespace App\Http\Requests\WebsitesRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormProtectedRequest;

class FindWebsiteRequest extends BaseFormProtectedRequest
{
    protected $permission = 'read website';


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
