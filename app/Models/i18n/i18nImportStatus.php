<?php

namespace App\Models\i18n;

use Illuminate\Database\Eloquent\Model;

class i18nImportStatus extends Model
{
    protected $table = 'i18n_import_status';

    protected $fillable = [
        'status'
    ];
}
