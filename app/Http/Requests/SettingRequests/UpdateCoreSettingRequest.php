<?php

namespace App\Http\Requests\SettingRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoreSettingRequest extends FormRequest
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
     * Exploit the json from the rquest
     *
     * @return bool
     */
    public function validationData()
    {
        return $this->json()->all();
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
            'model' => 'required|string',
            'type' => 'required|string',
            'sizes' => 'required|string',
            'max_allowed_files' => 'required|string',
            'jpg_quality' => 'required',
            'png_quality' => 'required'
        ];
    }
}
