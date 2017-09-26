<?php

namespace App\Http\Middleware;

use Auth;
use Redirect;
use Closure;

class RedirectNotHr
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
        if (empty(Auth::hasHr())) {

            return redirect::route('index');

        }

        return $next($request);
    }
}
