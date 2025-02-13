<?php

namespace App\Http\Middleware;

use App\Exceptions\NoPermissionException;
use App\Models\User;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Role extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param string $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = '')
    {
        /** @var User $user */
        $user = $request->user();
        if ($roles) {
            if ($user->hasAnyRole($roles)) {
                return $next($request);
            }
            throw new NoPermissionException;
        }
        return $next($request);
    }
}
