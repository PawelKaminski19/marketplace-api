<?php

namespace App\Models;

use App\Models\i18n\i18nLanguage;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Affiliate extends Model
{
    use hasRoles;
    /*
     * @var array
     * */
    protected $fillable = [
        'lang_id','lastname', 'firstname','uuid', 'active', 'terms_accepted',
        'terms_accepted_time','gender_id'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'lang_id' => 'integer',
        'active' => 'integer',
        'gender_id' => 'integer'
    ];
    /*
     * @var array
     * */
    protected $hidden = [
        'lang_id','gender_id'
    ];
    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Lang
    */
   public function lang()
   {
       return $this->belongsTo(i18nLanguage::class);
   }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Lang
   */
   public function gender()
   {
      return $this->belongsTo(Gender::class);
   }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\morphMany
   */
   public function users()
   {
         return $this->morphMany(User::class,'userable');
   }

   /**
   * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
   */
   public function clients()
   {
      return $this->belongsToMany(Client::class,'affiliates_clients');
   }

    /**
    * @return Collection
    */
    public function assignedClients()
    {
          return $this->clients;
    }
}
