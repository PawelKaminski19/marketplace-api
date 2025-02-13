<?php

namespace App\Http\Requests\CategoriesRequests;

use Illuminate\Foundation\Http\FormRequest;

class TreeCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $websiteId = (int)$this->route('websiteId');
        if (!$websiteId) {
            if (!auth()->user()) return false;
            return auth()->user()->hasRole('SuperAdmin');
        }

        // TODO - check for active flag in request and if active == 0 - check owner of the website.
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

        ];
    }
}
