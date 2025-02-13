<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'username', 'company_id', 'slug', 'secure_path', 'active'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'active' => 'integer'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Brand
    */
   public function brands()
   {
       return $this->belongsToMany(Brand::class,'clients_brands');
   }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Brand
   */
   public function roles()
   {
      return $this->belongsToMany(Brand::class,'clients_brands');
   }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Employee|Collection
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\hasMany|Customer|Collection
    */
   public function customers()
   {
       return $this->hasMany(Customer::class);
   }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\hasMany|Website|Collection
   */
  public function websites()
  {
      return $this->hasMany(Website::class);
  }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\morphMany
    */
    public function onBehalfUsers()
    {
        return $this->morphMany(User::class,'onbehalf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function uploads()
    {
        return $this->hasMany(Upload::class, 'client_id');
    }
    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Company
    */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    /**
    * @return \Illuminate\Database\Eloquent\Relations\hasMany|Domain
    */
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
