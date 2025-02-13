<?php

namespace App\Http\Requests\SettingRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormProtectedRequest;

class UpdateSettingRequest extends BaseFormProtectedRequest
{
    protected $permission = 'update setting';

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
