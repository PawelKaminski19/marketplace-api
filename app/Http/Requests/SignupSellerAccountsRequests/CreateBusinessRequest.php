<?php

namespace App\Http\Requests\SignupSellerAccountsRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBusinessRequest extends FormRequest
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
            'street' => 'required',
            'street_nr' => 'required|min:1|max:10',
            'city' => 'required',
            'ceos' => 'required|string',
            'phone' => 'required|regex:^[+]*[0-9]{1,4}[-\./0-9]*$^',
            'phone_country_id' => 'required|integer',
            'client_id' => 'required|integer',
            'register_nr' => 'required',
            'register_court' => 'required'
        ];
    }
}
