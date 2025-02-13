<?php

namespace App\Models;

use App\Models\Translatable\CountryTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = [
        'title'
    ];
    public $translationModel = CountryTranslation::class;

    /**
     * @var array
     */
    protected $fillable = [
        'currency_id', 'zone_id', 'title', 'locale', 'iso_code', 'call_prefix',
        'contains_states', 'need_zip_code', 'zip_code_format', 'display_tax_label', 'active'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'active' => 'integer',
        'currency_id' => 'integer',
        'zone_id' => 'integer',
        'display_tax_label' => 'integer',
    ];


    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Currency
    */
    public function currency()
    {
       return $this->belongsTo(Currency::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Zone
    */
    public function zone()
    {
       return $this->belongsTo(Zone::class);
    }
}
