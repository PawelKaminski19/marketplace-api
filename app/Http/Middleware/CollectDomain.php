<?php

namespace App\Http\Middleware;

use App\Services\ClientServices\ClientService;
use Closure;

class CollectDomain
{
    /**
     * Handle an incoming request.
     * This middleware checks the source of the domain by header "origin-domain" and saves it in the $request parameters
     * It also checks if the soruce domain of the request is a part of softwareowners domains list
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //adding some defaults values
        $request->attributes->add(['so-domain' => false]);
        $request->attributes->add(['origin-domain' => ""]);

        //checking if the header exists
        $originDomain = $request->header('origin-domain');
        if ($originDomain != null) {

            // remove port
            if (strpos($originDomain, ':') > 0) {
                $originDomain = substr($originDomain, 0, strpos($originDomain, ':'));
            }
            //saving the domains
            $request->attributes->add(['origin-domain' => $originDomain]);

            //collecting the list of SOs domains
            $soDomains = app()->make(ClientService::class)->getSoftwareOwner()->domains()->pluck('url')->toArray();
            if (in_array($originDomain, $soDomains)) {
                $request->attributes->add(['so-domain' => true]);
            }
        }

        return $next($request);
    }
}
