<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'address_id','company_id','name', 'title','subtitle', 'active'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'active' => 'integer'
    ];


   /**
   * @return \Illuminate\Database\Eloquent\Relations\has|Company
   */
   public function company()
   {
       return $this->has(Company::class);
   }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Company
    */
    public function companies()
    {
      return $this->belongsToMany(Website::class,'companies_locations');
    }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Address
   */
   public function address()
   {
       return $this->belongsTo(Address::class);
   }

}
