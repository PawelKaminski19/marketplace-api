<?php

namespace App\Models;

use App\Models\i18n\i18nLanguage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use hasRoles, Notifiable, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'client_id', 'website_id', 'lang_id', 'country_id', 'group_id', 'company', 'lastname', 'firstname', 'country_code',
        'phone', 'digest_has', 'accepted_terms', 'newsletter_sub', 'newsletter_optin', 'newsletter_unsub', 'note', 'is_guest',
        'active', 'terms_accepted', 'terms_accepted_time', 'gender_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'client_id' => 'integer',
        'lang_id' => 'integer',
        'website_id' => 'integer',
        'country_id' => 'integer',
        'group_id' => 'integer',
        'active' => 'integer',
        'gender_id' => 'integer'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'client_id', 'website_id', 'lang_id',' gender_id', 'group_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Lang
     */
    public function lang()
    {
        return $this->belongsTo(i18nLanguage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Gender
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Group
     */
    public function groups()
    {
        return $this->belongsToMany(Brand::class, 'customers_groups');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_customers');
    }

    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function onBehalfUsers()
    {
        return $this->morphMany(User::class, 'onBehalf');
    }

    /**
    * @return Collection
    */
    public function assignedClients()
    {
          return collect([$this->client]);
    }
}
