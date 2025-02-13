<?php

namespace App\Http\Requests\VariantRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user() && auth()->user()->hasPermissionTo('create variant')) {
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
            'variant_group_id' => 'required|integer|min:1',
            'title' => 'required|string|max:150',
            'subtitle' => 'required|string|max:255',
            'position' => 'integer|min:0',
            'delivery_days' => 'integer|min:0',
            'optional' => 'boolean'
        ];
    }
}
