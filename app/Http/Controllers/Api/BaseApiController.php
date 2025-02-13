<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DomainServices\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseApiController extends Controller
{
    /** @var Auth */
    protected $user;

    /** @var Domain */
    protected $domain;

    /** @var bool */
    protected $soDomain;

    /**
     * Create a new BaseApiController instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct()
    {
        $request = request();
        //set up a use
        if (Auth::user()) {
            $this->user = Auth::user();
        }

        //here is the SOURCE of the request (the address from which the request came)
        //using this we can check if the user can do some custom actions (ie. if given user can login from the certain web page)
        $domainUrl = $request->attributes->get('origin-domain');
        if ($domainUrl) {
            $this->domain = app()->make(DomainService::class)->findByDomain($domainUrl);
        }

        //now checking, if the source of the request is the softwareowner's main page
        $this->soDomain = $request->attributes->get('so-domain');
    }
}
