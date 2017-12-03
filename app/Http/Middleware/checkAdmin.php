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
        if(Auth::check() && Auth::user()->role_id==2){//is Admin
            return $next($request);
        }else{
            return Redirect::route('/')->with('error_code', 1);
            // return Redirect::back()->with('error_code', 1);  
        }
    }
}
