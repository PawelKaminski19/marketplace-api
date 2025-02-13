<?php

namespace App\Http\Requests\ProductRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user() && auth()->user()->hasPermissionTo('create product')) {
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
            'client_id' => 'integer|min:0',
            'website_id' => 'integer|min:0',
            'brand_id' => 'integer|min:0',
            'category_id' => 'integer|min:0',
            'tax_rule_group_id' => 'integer|min:0',
            'path' => 'string',
            // 'url' => 'required|string|max:128',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            // 'description_short' => 'required|string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            // 'ean13' => 'string|max:13',
            // 'reference' => 'string|max:32',
            'reference_brand' => 'string|max:32',
            'price' => 'numeric',
            'show_price' => 'boolean',
            'width' => 'numeric',
            'height' => 'numeric',
            'depth' => 'numeric',
            'weight' => 'numeric',
            // 'available_text' => 'string|max:50',
            'available_days' => 'integer',
            'available_date' => 'date',
            'redirect_type' => 'integer',
            'redirect_product_id' => 'integer',
            // 'active' => 'boolean',
            'combinations' => 'array'
        ];
    }
}
