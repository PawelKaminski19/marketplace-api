<?php

namespace App\Models;

use App\Models\Translatable\VariantTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;
    use SoftDeletes;

    public $translationModel = VariantTranslation::class;

    public $translatedAttributes = [
        'title', 'subtitle'
    ];

    protected $fillable = [
        'variant_group_id', 'position', 'optional', 'delivery_days', 'deleted_at', 'updated_at',
        'created_at', 'title', 'subtitle'
    ];

    protected $casts = [
        'variant_group_id' => 'integer',
    ];

    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    public function variantGroup()
    {
        return $this->belongsTo(VariantGroup::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variants');
    }

    public function websiteProducts()
    {
        return $this->belongsToMany(WebsitesProduct::class, 'websites_products_variants');
    }

    public function variantCombinations()
    {
        return $this->belongsToMany(ProductVariantCombination::class, 'product_variants');
    }
}
