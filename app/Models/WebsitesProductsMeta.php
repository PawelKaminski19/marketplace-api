<?php
namespace App\Models;

use App\Models\Translatable\WebsiteProductMetaTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;

class WebsitesProductsMeta extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = [
        'name',
        'description', 'description_short', 'meta_title', 'meta_description', 'meta_keywords', 'available_text'
    ];
    public $translationModel = WebsiteProductMetaTranslation::class;

    /**
     * @var string
     */
    protected $table = 'websites_products_metas';

    protected $fillable = [
        'name',
        'description', 'description_short', 'meta_title', 'meta_description', 'meta_keywords', 'ean13',
        'reference', 'reference_brand', 'price', 'show_price', 'width', 'heigh', 'weight', 'available_text',
        'available_days', 'available_date', 'redirect_type', 'redirect_product_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne|Product
     */
    public function websitesProduct()
    {
        return $this->hasOne(Product::class, 'website_product_meta_id');
    }
}
