<?php

namespace App\Http\Middleware;

use Auth;
use Redirect;
use Closure;

class RedirectNotManager
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
        if (empty(Auth::hasManagement())) {

            return redirect::route('index');

        }

        return $next($request);
    }
}
