<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class VariantGroupTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'title', 'subtitle', 'variant_group_id', 'locale'
    ];
}
