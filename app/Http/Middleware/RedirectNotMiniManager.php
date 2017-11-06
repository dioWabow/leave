<?php

namespace App\Http\Middleware;

use Auth;
use Redirect;
use Closure;

class RedirectNotMiniManager
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
        if (empty(Auth::hasMiniManagement())) {

            return redirect::route('index');

        }

        return $next($request);
    }
}
