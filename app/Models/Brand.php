<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Brand extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'client_id','name', 'slug','url', 'active', 'approved'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'client_id' => 'integer',
        'active' => 'integer'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Client
    */
   public function clients()
   {
       return $this->belongsToMany(Client::class,'clients_brands');
   }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Website
   */
   public function websites()
   {
      return $this->belongsToMany(Website::class, 'websites_brands');
   }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function uploads()
    {
      return $this->hasMany(Upload::class, 'model_id')->where('model', '=', 'brand');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany|Collection
    */
    public function products()
    {
      return $this->hasMany(Product::class);
    }
}
