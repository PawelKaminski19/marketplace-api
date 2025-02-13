<?php

namespace App\Models;

use App\Models\Translatable\CategoryTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements Translatable
{
    private static $filters = null;
    private static $websiteId = null;

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = [
        'path', 'slug', 'url', 'title', 'description', 'meta_title', 'meta_description', 'meta_keywords'
    ];
    public $translationModel = CategoryTranslation::class;

    protected $appends = [
        'images'
    ];

    /*
     * @var array
     * */
    protected $fillable = [
        'website_id', 'parent_id', 'depth', 'root', 'position', 'slug', 'url', 'title', 'description', 'meta_title',
        'meta_description', 'meta_keywords', 'active', 'created_at', 'updated_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'active' => 'integer',
        'website_id' => 'integer',
        'parent_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Client
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'clients_brands');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Category
    */
    public function child()
    {
        $query = $this->hasMany(Category::class, 'parent_id')->with('child');
        if (self::$websiteId) {
            $query->where('website_id', self::$websiteId);
        }

        if (self::$filters) {
            if (isset(self::$filters['active']) && self::$filters['active']) {
                $query->where('active', self::$filters['active']);
            }
        }
        return $query;
    }

    /**
     * Get categories tree.
     *
     * @param int $websiteId
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function tree($websiteId, $filters)
    {
        self::$filters = $filters;
        self::$websiteId = $websiteId;

        $rootQuery = self::whereNull('parent_id')->where('depth', 0);
        if ($websiteId) {
            $rootQuery->where('website_id', $websiteId);
        }
        else {
            $rootQuery->whereNull('website_id');
        }
        $root = $rootQuery->first();

        $query = $this->query()->with(['child']);
        if ($websiteId) {
            $query->where('website_id', $websiteId);
        }
        else {
            $query->whereNull('website_id');
        }

        $query->where('parent_id', $root->id);
        if (isset($filters['active']) && $filters['active']) {
            $query->where('active', $filters['active']);
        }
        $data = $query->get();

        self::$filters = null;
        self::$websiteId = null;

        return $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function upload()
    {
        return $this->hasOne(Upload::class, 'model_id')->where('model', Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|WebsitesProduct
     */
    public function websitesProducts()
    {
        return $this->hasMany(WebsitesProduct::class);
    }

    public function getImagesAttribute()
    {
        if ($this->upload()->count() > 0) {
            return $this->upload;
        }

        return [];
    }
}
