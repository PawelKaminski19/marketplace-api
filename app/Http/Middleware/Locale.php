<?php

namespace App\Http\Middleware;

class Locale
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->has('locale')) {
            \App::setLocale($request->get('locale', 'de'));
        }
        return $next($request);
    }
}
