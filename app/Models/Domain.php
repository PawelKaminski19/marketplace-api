<?php

namespace App\Models;

use App\Repositories\DomainRepository;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    /*
     * @var array
     * */
    protected $fillable = [
        'client_id', 'website_id', 'https', 'url', 'analytics', 'main',
        'live', 'active'
    ];

    protected $appends = [
        'redirection'
    ];

    /*
     * @var array
     * */
    protected $casts = [
        'client_id' => 'integer',
        'website_id' => 'integer',
        'https' => 'integer',
        'main' => 'integer',
        'live' => 'integer',
        'active' => 'integer'
    ];


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

    public function getRedirectionAttribute()
    {
        if (!$this->main) {
            /** @var DomainRepository $repository */
            $repository = app()->make(DomainRepository::class);
            $query = $repository->query()->where('website_id', $this->website_id)->where('main', 1)->where('live', 1)->where('active', 1);
            if (strpos($this->url, '.test') !== false) {
                $query->where('url', 'LIKE', '%test');
            }
            return $query->first();
        }

        return null;
    }



}
