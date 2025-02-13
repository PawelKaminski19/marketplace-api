<?php

namespace App\Http\Requests\PasswordRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:6|max:15|same:passwordRepeat',
            'passwordRepeat' => 'required|string|min:6|max:15|same:password',
        ];
    }
}
