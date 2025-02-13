<?php

namespace App\Http\Requests\SignupSellerAccountsRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrimaryContactRequest extends FormRequest
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'citizen_country_id' => 'required|integer',
            'birth_country_id' => 'required|integer',
            'birth_date' => 'required|date_format:Y-m-d',
            'identity_proof_type' => 'required',
            'identity_proof_nr' => 'required',
            'identity_proof_expiry' => 'required|date_format:Y-m-d',
            'zip' => 'required',
            'street' => 'required|string',
            'city' => 'required|string',
            'street_nr' => 'required',
            'uuid' => 'required',
            'client_id' => 'required|integer'
        ];
    }
}
