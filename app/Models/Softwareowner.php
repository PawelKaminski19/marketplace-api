<?php

namespace App\Models;

use App\Models\i18n\i18nLanguage;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Softwareowner extends Model
{
    use hasRoles;
    /*
     * @var array
     * */
    protected $fillable = [
        'client_id','lang_id','lastname','firstname','active'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'lang_id' => 'integer',
        'active' => 'integer',
    ];

    /*
     * @var array
     * */
    protected $hidden = [
        'lang_id', 'client_id'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Lang
    */
    public function lang()
    {
       return $this->belongsTo(i18nLanguage::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\hasOne|User
    */
    public function user()
    {
          return $this->hasOne(User::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
    */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\morphMany
    */
    public function users()
    {
       return $this->morphMany(User::class,'userable');
    }


    /**
    * @return Collection
    */
    public function assignedClients()
    {
          return collect([$this->client]);
    }

}
