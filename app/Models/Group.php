<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'client_id','reduction','price_display_method','show_prices'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'client_id' => 'integer'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Customer
    */
    public function customers()
    {
       return $this->belongsToMany(Customer::class,'customers_groups');
    }
    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
    */
    public function client()
    {
          return $this->belongsTo(Client::class);
    }
}
