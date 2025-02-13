<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class WebsiteTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'website_id', 'locale', 'title', 'subtitle', 'logotitle', 'logosubtitle', 'meta_title', 'meta_description', 'meta_keywords'
    ];
}
