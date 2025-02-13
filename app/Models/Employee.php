<?php

namespace App\Models;

use App\Models\i18n\i18nLanguage;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use hasRoles;
    /*
     * @var array
     * */
    protected $fillable = [
        'client_id','lang_id','lastname','firstname','active', 'terms_accepted',
        'terms_accepted_time','gender_id'
    ];

    /*
     * @var array
     * */
    protected $hidden = [
        'client_id','lang_id','gender_id'
    ];
    /*
     * @var array
     * */
    protected $casts = [
        'client_id' => 'integer',
        'lang_id' => 'integer',
        'active' => 'integer',
        'gender_id' => 'integer'
    ];



    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
    */
    public function client()
    {
          return $this->belongsTo(Client::class);
    }


    /**
    * @return Collection
    */
    public function assignedClients()
    {
          return collect([$this->client]);
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
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
    */
    public function usersAssigned()
    {
        return $this->belongsToMany(User::class,'users_employees');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\morphMany
    */
    public function users()
    {
        return $this->morphMany(User::class,'userable');
    }

}
