<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'website_id', 'name'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }

    public function websitesProducts()
    {
        return $this->belongsToMany(WebsitesProduct::class, 'product_tags');
    }
}
