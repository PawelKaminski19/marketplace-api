<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsUpload extends Model
{
    /*
     * @var string
     * */

    protected $table = "settings_uploads";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'website_id', 'domain_id', 'core','model', 'type', 'sizes', 'max_allowed_files', 'jpg_quality', 'png_quality'
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\hasMany|Client
    */
    public function clients()
    {
        return $this->hasMany(Client::class, 'client_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Website
    */
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function model()
     {
         return $this->morphTo('model',"model","model_id");
     }


}
