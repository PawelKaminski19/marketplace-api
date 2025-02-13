<?php

namespace App\Models\i18n;

use Illuminate\Database\Eloquent\Model;

class i18nModule extends Model
{
    protected $table = 'i18n_modules';

    protected $fillable = [
        'name'
    ];
}
