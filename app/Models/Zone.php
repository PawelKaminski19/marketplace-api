<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'name', 'active'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'name' => 'integer',
        'active' => 'integer'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\hasMany|Country
    */
    public function countries()
    {
       return $this->hasMany(Country::class);
    }
    
}
