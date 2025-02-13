<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPrimaryContact extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'company_id','address_id','citizen_country_id','birth_country_id','birth_date', 'identity_proof_type',
        'identity_proof_nr','identity_proof_expiry','active'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'active' => 'integer'
    ];


    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Company
    */
    public function company()
    {
       return $this->belongsTo(Company::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Address
    */
    public function address()
    {
       return $this->belongsTo(Address::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Country
    */
    public function citizenCountry()
    {
       return $this->belongsTo(Country::class,"citizen_country_id");
    }


}
