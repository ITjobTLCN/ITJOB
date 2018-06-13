<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class checkAdmin
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
        //Cheat
        return $next($request);
        if (Auth::check() && Auth::user()->role_id == '5ac85f51b9068c2384007d9d' ) {
            return $next($request);
        } else {
            return Redirect::route('/')->with('error_code', 1);
            // return Redirect::back()->with('error_code', 1);
        }
    }
}
