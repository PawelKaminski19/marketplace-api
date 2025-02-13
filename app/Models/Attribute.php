<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
     */
    public function uploads()
   {
       return $this->belongsToMany(Upload::class, 'attributes_uploads');
   }

}
