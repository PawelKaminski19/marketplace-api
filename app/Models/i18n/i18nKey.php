<?php

namespace App\Models\i18n;

use Illuminate\Database\Eloquent\Model;

class i18nKey extends Model
{
    const TYPE_SIMPLE = 1; // simple translation, just text and nothing else
    const TYPE_COMPLEX = 2;  // complex translation - wysiwyg editor

    protected $table = 'i18n_keys';

    protected $fillable = [
        'module_id', 'key', 'type'
    ];

    public function module()
    {
        return $this->belongsTo(i18nModule::class);
    }
}
