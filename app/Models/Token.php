<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'hash', 'type', 'model', 'model_id', 'method', 'used', 'used_date', 'expiration_minutes', 'expiration_date', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\MorphTo
    */
    public function model()
    {
        return $this->morphTo('model',"model","model_id");
    }

}
