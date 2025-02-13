<?php

namespace App\Models;

use App\Models\Translatable\ProductTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;
    use SoftDeletes;

    public $translatedAttributes = [
        'url', 'name', 'description', 'description_short', 'meta_title', 'meta_description', 'meta_keywords'
    ];
    public $translationModel = ProductTranslation::class;

    /**
     * @var array
     */
    protected $fillable = [
        'client_id', 'website_id', 'brand_id', 'category_id', 'tax_rule_group_id',
        'path', 'url', 'name', 'description', 'description_short', 'meta_title',
        'meta_description', 'meta_keywords', 'ean13', 'reference', 'reference_brand',
        'price', 'show_price', 'width', 'height', 'depth', 'weight',
        'available_text',' available_days', 'available_date', 'redirect_type',
        'redirect_product_id', 'active'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'client_id' => 'integer',
        'website_id' => 'integer',
        'brand_id' => 'integer',
        'category_id' => 'integer',
        'tax_rule_group_id' => 'integer',
        'redirect_product_id' => 'integer',
        'active' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function settingsuploads()
    {
        return $this->morphMany(SettingsUpload::class, 'model');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function uploads()
    {
        return $this->morphMany(Upload::class, 'model', 'model');
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'product_variants');
    }

    public function variantsCombinations()
    {
        return $this->hasMany(ProductVariantCombination::class);
    }

    public function websiteProducts()
    {
        return $this->hasMany(WebsitesProduct::class, 'product_id');
    }

    public function shops()
    {
        return $this->belongsToMany(Website::class, WebsitesProduct::class, 'product_id')->distinct();
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, WebsitesProduct::class)->distinct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Category
     */
    public function secondaryCategories()
    {
        return $this->belongsToMany(Category::class, 'categories_products');
    }

    // TODO Uncomment when TaxRule is made
//    public function taxRule()
//    {
//        return $this->belongsTo(TaxRule::class);
//    }
}
