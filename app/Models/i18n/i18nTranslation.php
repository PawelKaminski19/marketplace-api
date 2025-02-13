<?php

namespace App\Models\i18n;

use Illuminate\Database\Eloquent\Model;

class i18nTranslation extends Model
{
    protected $table = 'i18n_translations';

    protected $fillable = [
        'language_id', 'module_id', 'key_id', 'translation'
    ];

    public function module()
    {
        return $this->belongsTo(i18nModule::class);
    }

    public function language()
    {
        return $this->belongsTo(i18nLanguage::class);
    }

    public function key()
    {
        return $this->belongsTo(i18nKey::class);
    }
}
