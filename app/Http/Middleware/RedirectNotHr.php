<?php

namespace App\Http\Middleware;

use Auth;
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

            return redirect('index');

        }

        return $next($request);
    }
}
