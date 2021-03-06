<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class checkEmp
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
        if (Auth::check()) {
            if (in_array(Auth::user()->role_id, config('constant.roleEmployer'))) {
                return $next($request);
            } else {
                return Redirect::route('getRegisterEmployer'); //không có quyền employer
            }
        } else {
            return Redirect::route('login');
        }
    }
}
