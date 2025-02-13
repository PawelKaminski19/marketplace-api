<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'locale', 'url', 'name', 'description', 'description_short', 'meta_title', 'meta_description', 'meta_keywords'
    ];
}
