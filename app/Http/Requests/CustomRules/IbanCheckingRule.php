<?php
namespace App\Http\Requests\CustomRules;

use Illuminate\Contracts\Validation\Rule;

class IbanCheckingRule implements Rule
{
    public function passes($attribute, $value)
    {
        return verify_iban($value);
    }

    public function message()
    {
        return ':attribute not a valid IBAN number';
    }
}
