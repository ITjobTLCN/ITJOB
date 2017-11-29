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
        if(Auth::check()){
            if(Auth::user()->role_id==3 || Auth::user()->role_id==4){
                return $next($request);
            }else{
                return Redirect::route('/')->with('error_code', 2); //không có quyền employer
            }
        }else{
            return Redirect::route('/')->with('error_code', 1); // 1: chưa đăng nhập
        }
        
    }
}
