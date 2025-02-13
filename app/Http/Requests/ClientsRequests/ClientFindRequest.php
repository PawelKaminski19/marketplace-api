<?php

namespace App\Http\Requests\ClientsRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormProtectedRequest;

class ClientFindRequest extends BaseFormProtectedRequest
{
    protected $permission = 'read client';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clientId' => 'integer',
        ];
    }
}
