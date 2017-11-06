<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
        if(Auth::check()){
            if(Auth::user()->role_id==2){
                return $next($request);
            }
            Auth::logout();
            return redirect()->route('getlogin')->with(['message'=>'You are not Admin']);
        }
        return redirect()->route('getlogin');
    }
}
