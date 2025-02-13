<?php

namespace App\Http\Requests\VariantGroupRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantGroupRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user() && auth()->user()->hasPermissionTo('update variant group')) {
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
            'name' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'client_id' => 'required|integer|min:0',
            'subtitle' => 'string|max:255',
            'website_id' => 'integer|min:0',
            'position' => 'integer|min:0'
        ];
    }
}
