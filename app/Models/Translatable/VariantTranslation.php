<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class VariantTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'subtitle', 'variant_id', 'locale'
    ];
}
