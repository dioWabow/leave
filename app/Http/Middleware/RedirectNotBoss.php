<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectNotBoss
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
        if (empty(Auth::hasAdmin())) {

            return redirect('index');

        }

        return $next($request);
    }
}
