<?php

namespace App\Models;

use App\Services\UploadServices\UploadService;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'uuid', 'client_id', 'website_id', 'user_id', 'model', 'model_id',
        'order', 'type', 'subtype', 'title', 'name', 'subfolder',
        'mimetype', 'extension', 'size', 'hash', 'md5', 'complete', 'dimensions'
    ];

    protected $casts = [

    ];

    protected $appends = [
        'url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function settings()
    {
        return $this->belongsToMany(Setting::class, 'settings', 'client_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\MorphTo
    */
    public function upload()
    {
        return $this->morphTo('model',"model","model_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|User
    */
    public function user()
    {
       return $this->belongsTo(User::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
    */
    public function client()
    {
       return $this->belongsTo(Client::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Website
    */
    public function website()
    {
       return $this->belongsTo(Website::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany|Collection
    */
    public function attributes()
    {
       return $this->belongsTo(Attribute::class, 'attributes_uploads');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function model()
     {
         return $this->morphTo('model', 'model', 'model_id');
     }

     public function getUrlAttribute()
     {
         if (!$this->complete) return null;

         /** @var UploadService $uploadService */
         $uploadService = app()->make(UploadService::class);
         return $uploadService->getURL($this);
     }
}
