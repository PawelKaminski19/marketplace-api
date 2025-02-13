<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'country_id', 'locale', 'title'
    ];
}
