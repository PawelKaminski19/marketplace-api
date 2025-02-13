<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class WebsiteProductMetaTranslation extends Model
{
    protected $table = 'websites_products_meta_translations';

    public $timestamps = false;

    protected $fillable = [
        'websites_products_meta_id', 'name', 'locale', 'description', 'description_short', 'meta_title', 'meta_description', 'meta_keywords', 'available_text'
    ];
}
