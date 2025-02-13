<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, hasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','userable_id','userable_type','onbehalf_id','onbehalf_type', 'onbehalf_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','userable_id','userable_type','softwareowner_id','onbehalf_id','onbehalf_type', 'onbehalf_time'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
      * Password mutator
      *
      * @return mixed
      */
      public function setPasswordAttribute($value)
      {
          $this->attributes['password'] = \Hash::make($value);
      }

    /**
      * Get the identifier that will be stored in the subject claim of the JWT.
      *
      * @return mixed
      */
     public function getJWTIdentifier()
     {
         return $this->getKey();
     }

     /**
      * Return a key value array, containing any custom claims to be added to the JWT.
      *
      * @return array
      */
     public function getJWTCustomClaims()
     {
         return [];
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
     */
     public function brands()
     {
           return $this->belongsToMany(Brand::class,'users_brands');
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
     */
     public function customers()
     {
           return $this->belongsToMany(Customer::class,'users_customers');
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
     */
     public function employees()
     {
        return $this->belongsToMany(Employee::class,'users_employees');
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Softwareowner
     */
     public function softwareowner()
     {
        return $this->belongsTo(Softwareowner::class);
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
     */
     public function affiliates()
     {
        return $this->belongsToMany(Affiliate::class,'users_affiliates');
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function userable()
     {
         return $this->morphTo();
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function onBehalf()
     {
         return $this->morphTo('onbehalf',"onbehalf_type","onbehalf_id");
     }
}
