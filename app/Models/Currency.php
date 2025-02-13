<?php

namespace App\Models;

use App\Models\Translatable\CurrencyTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;
    use SoftDeletes;

    public $translatedAttributes = [
        'name'
    ];
    public $translationModel = CurrencyTranslation::class;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'iso_code', 'iso_code_num', 'sign', 'blank', 'format',
        'decimals', 'conversion_rate', 'active'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'active' => 'integer'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\hasMany|Country
    */
    public function countries()
    {
       return $this->hasMany(Country::class);
    }


}
