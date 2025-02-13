<?php

namespace App\Http\Requests\SignupSellerAccountsRequests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CustomRules\IbanCheckingRule;

class CreatePaymentInfoRequest extends FormRequest
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
        if ($this->has('invoice') && $this->invoice == 1) {
            return [
                'client_id' => 'required|integer',
                'lang_id' => 'required_without:invoice|integer'
            ];
        } else {
            return [
                'client_id' => 'required|integer',
                'lang_id' => 'required_without:invoice|integer',
                'iban' => [new IbanCheckingRule],
                'bic' => 'required',
                'owner' => 'required|string'
            ];  
        }

    }
}
