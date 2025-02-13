<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'model', 'model_id', 'country_id', 'gender_id', 'name', 'organization','state',
        'organization_title', 'firstname', 'middlename', 'lastname', 'street', 'street_nr','address2', 'address3', 'zip','email',
        'phone', 'phone2', 'mobile', 'mobile2', 'url', 'map_zoom', 'map_lat', 'map_lng', 'streetview_lng',
        'streetview_lat', 'standard', 'active'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo('model', 'model', 'model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Gender
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
