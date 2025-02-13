<?php

namespace App\Http\Requests\ClientsRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserServices\UsersAccountService;

class ClientAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $usersAccountService = app()->make(UsersAccountService::class);

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
            'website_id' => 'integer',
            'url' => 'string',
        ];
    }
}
