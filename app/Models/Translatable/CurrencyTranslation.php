<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'currency_id', 'locale', 'name'
    ];
}
