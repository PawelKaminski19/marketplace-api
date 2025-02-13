<?php

namespace App\Models\Translatable;

use Illuminate\Database\Eloquent\Model;

class GenderTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'gender_id', 'locale', 'title'
    ];
}
