<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Session;
use View;
use \App\Job;
use \App\Cities;
use \App\Employers;
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
        view()->composer('partials.search-job', function($view) {
            $cities = Cache::remember('listLocation', 10, function() {
                return Cities::all();
            });

            $view->with('cities', $cities);
        });

        view()->composer('partials.top-emps', function($view) {
            $top_emps = Cache::remember('topEmployer', 10, function() {
                return Employers::select('name', 'alias', 'images.avatar')
                                ->where('status', 1)
                                ->orderBy('rating desc')
                                ->orderBy('quantity_user_follow desc')
                                ->offset(0)
                                ->take(12)
                                ->get();
            });

            $view->with('top_emps', $top_emps);
        });

        view()->composer('partials.recommend_jobs', function($view) {
            $listJobLastest = [];
            $listJobLastest = Job::with('employer')->where('status', 1)
                                        ->orderBy('_id', 'desc')
                                        ->offset(0)
                                        ->take(config('constant.limit.job'))
                                        ->get();

            $view->with(['countjob' => count($listJobLastest), 'listJobLastest' => $listJobLastest]);
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
