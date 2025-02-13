<?php

namespace App\Models\i18n;

use App\Models\Affiliate;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Guest;
use App\Models\Softwareowner;
use Illuminate\Database\Eloquent\Model;

class i18nLanguage extends Model
{
    protected $table = 'i18n_languages';

    protected $fillable = [
        'name', 'locale', 'sign', 'active', 'language_code', 'date_format_lite', 'date_format_full', 'is_rtl'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'active' => 'integer',
        'is_rtl' => 'integer'
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
