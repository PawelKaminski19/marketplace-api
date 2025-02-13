<?php

namespace App\Models;

use App\Models\Translatable\GenderTranslation;
use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model implements Translatable
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = [
        'title'
    ];
    public $translationModel = GenderTranslation::class;

    /**
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Customer
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Employee
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Affiliate
     */
    public function affiliates()
    {
        return $this->hasMany(Affiliate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Softwareowner
     */
    public function softwareowners()
    {
        return $this->hasMany(Softwareowner::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|Guest
     */
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
