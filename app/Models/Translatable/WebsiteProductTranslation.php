<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class WebsiteProductTranslation extends Model
{
    protected $table = 'websites_product_translations';

    public $timestamps = false;

    protected $fillable = [
        'websites_products_id', 'locale', 'url'
    ];
}
