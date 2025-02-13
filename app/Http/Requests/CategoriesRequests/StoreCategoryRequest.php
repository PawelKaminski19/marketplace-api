<?php

namespace App\Http\Requests\CategoriesRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->hasPermissionTo('create category')) {
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
            'website_id' => 'integer',
            'parent_id' => 'integer',
            'depth' => 'integer',
            'root' => 'integer',
            'position' => 'integer',
            'slug' => 'required|string',
            'url' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'ean13' => 'unique',
            'isbn' => 'unique',
            'upc' => 'unique',
            'active' => 'boolean'
        ];
    }
}
