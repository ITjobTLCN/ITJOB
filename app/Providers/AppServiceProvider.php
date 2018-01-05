<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Session;
use View;
use \App\Jobs;
use \App\Cities;
use DB;
use Cache;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.related-jobs',function($view){
            $view->with('relatedJob',Session::get('relatedJob'));
        });
        view()->composer('partials.job-most-viewer',function($view){
            $jobs=DB::table('employers as e')
                    ->select('a.*','e.name as en','e.logo','c.name as cn')
                    ->join(DB::raw('(select id,name,alias,city_id,emp_id,description,salary,created_at from jobs order by views desc) as a'),function($join){
                        $join->on('e.id','=','a.emp_id');
                    })->join('cities as c','a.city_id','=','c.id')->offset(0)->take(8)->get();
            $view->with('topJobViewer',$jobs);
        });
        view()->composer('partials.search-job',function($view){
            $cities=Cache::remember('listLocation', 10, function() {
                return Cities::all();
            });
            $view->with('cities',$cities);
        });
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
