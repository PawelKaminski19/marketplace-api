<?php
namespace App\Models;

use App\Models\Translatable\WebsiteProductTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class WebsitesProduct extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = [
        'url'
    ];
    public $translationModel = WebsiteProductTranslation::class;

    protected $table = 'websites_products';

    protected $appends = [
        'images'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'client_id', 'website_id', 'brand_id', 'category_id', 'product_id',
        'website_product_meta_id', 'tax_rule_group_id', 'url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Category
     */
    public function secondaryCategories()
    {
        return $this->belongsToMany(Category::class, 'websites_products_categories');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|WebsitesProductsMeta
     */
    public function websitesProductsMeta()
    {
        return $this->belongsTo(WebsitesProductsMeta::class, 'website_product_meta_id');
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'websites_products_variants', 'websites_product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function uploads()
    {
        return $this->morphMany(Upload::class, 'model', 'model');
    }

    public function getImagesAttribute()
    {
        if ($this->uploads()->count()) {
            return $this->uploads;
        }

        if ($this->product) {
            return $this->product->uploads;
        }

        return [];
    }

    /**
     * Get all shops connected to this product as a collection (not relation!).
     *
     * @return Collection
     */
    public function shops()
    {
        if ($this->product) {
            return $this->product->shops;
        }
        return collect([]);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'websites_product_id');
    }
}
