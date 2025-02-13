<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'uuid','business_type','location_id','uuid', 'title','subtitle','ceos', 'register_court', 'register_nr', 'tax_id_nr','vat_number', 'active'
    ];
    /*
     * @var array
     * */
    protected $casts = [
        'active' => 'integer'
    ];
    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Location
    */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Location
    */
    public function locations()
    {
        return $this->belongsToMany(Location::class, "companies_locations");
    }
}
