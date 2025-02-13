<?php

namespace App\Models;

use App\Models\Translatable\WebsiteTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;
    use SoftDeletes;

    public $translatedAttributes = [
        'title', 'subtitle', 'logotitle', 'logosubtitle', 'meta_title', 'meta_description', 'meta_keywords'
    ];
    public $translationModel = WebsiteTranslation::class;

    /**
     * @var array
     */
    protected $fillable = [
        'client_id', 'category_id', 'brand_id', 'url', 'title', 'subtitle', 'logotitle', 'slug',
        'meta_title', 'meta_description', 'meta_keywords', 'layout', 'active'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'client_id' => 'integer',
        'category_id' => 'integer',
        'brand_id' => 'integer',
        'active' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Brand
     */
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'websites_brands');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Collection
     */
    public function uploads()
    {
        return $this->hasMany(Upload::class, 'website_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Company
     */
    public function company()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Company
     */
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
