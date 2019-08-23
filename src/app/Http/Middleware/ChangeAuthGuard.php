<?php

namespace Ipsum\Admin\app\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ChangeAuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('auth')->setDefaultDriver(config('ipsum.admin.guard'));

        return $next($request);
    }
}
