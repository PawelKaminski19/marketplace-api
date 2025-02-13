<?php

namespace App\Http\Requests\SignupRequests;

use Illuminate\Foundation\Http\FormRequest;

class GuestSignupRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname' => 'required',
            'gender_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|integer',
            'terms_accepted' => 'digits_between:0,1'
        ];
    }

}
