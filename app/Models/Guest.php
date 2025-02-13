<?php

namespace App\Models;

use App\Models\i18n\i18nLanguage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Guest extends Model
{
    use Notifiable;

    /*
     * @var array
     * */
    protected $fillable = [
        'session', 'uuid', 'website_id', 'domain_id', 'customer_id', 'country_id', 'user_id', 'employee_id', 'currency_id', 'lang_id', 'email_is_verified', 'email_is_verified_at', 'gender_id',
        'email', 'firstname', 'lastname', 'phone', 'phone_country_id', 'accept_language', 'ip', 'operating_system', 'web_browser',
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'website_id' => 'integer',
        'domain_id' => 'integer',
        'customer_id' => 'integer',
        'country_id' => 'integer',
        'currency_id' => 'integer',
        'lang_id' => 'integer',
        'lgender_id' => 'integer',
        'phone_country_id' => 'integer',
        'email_is_verified' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Domain
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Lang
     */
    public function lang()
    {
        return $this->belongsTo(i18nLanguage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Country
     */
    public function phoneCountry()
    {
        return $this->belongsTo(Country::class, "phone_country_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Gender
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function token()
    {
        return $this->morphMany(Token::class, 'model');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function getRelated()
    {
        return $this->load('website', 'gender', 'domain', 'country', 'currency', 'phoneCountry', 'employee', 'user');
    }

}
