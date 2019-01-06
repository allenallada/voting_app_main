<?php

namespace App\Http\Middleware;

use Closure;

class AppKeyVerify
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
        if(request('app_key') === env('APP_KEY')) return $next($request);
        
        return null;
    }
}