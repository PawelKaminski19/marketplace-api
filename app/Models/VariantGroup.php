<?php

namespace App\Models;

use App\Models\Translatable\VariantGroupTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;

class VariantGroup extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;

    public $translationModel = VariantGroupTranslation::class;

    public $translatedAttributes = [
        'name', 'title', 'subtitle'
    ];

    protected $fillable = [
        'client_id', 'website_id', 'name', 'title' , 'subtitle', 'position', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'client_id' => 'integer',
        'website_id' => 'integer',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
