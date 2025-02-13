<?php

namespace App\Http\Requests\BrandsRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->hasPermissionTo('edit brand')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|integer',
            'name' => 'required|unique|string|max:64',
            'slug' => 'string|max:64',
            'url' => 'string|max:64',
            'active' => 'boolean'
        ];
    }
}
