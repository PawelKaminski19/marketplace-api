<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category_id', 'path', 'locale', 'slug', 'url', 'title', 'description', 'meta_title', 'meta_description', 'meta_keywords'
    ];
}
