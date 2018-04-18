<?php

namespace App\Traits;
use Cache;
use App\Employers;
use App\Job;
use DB;
trait LatestMethod
{
	private function getTopEmployers() {
		$top_emps = Cache::remember('top_emps', config('constant.cacheTime'), function() {
            return Employers::orderBy('rating desc')
            				->orderBy('quantity_user_follow desc')
            				->offset(0)
                        	->take(config('constant.limitCompany'))
                            ->get();
         });
         return $top_emps;
	}
	public function getTopJobs()
	{
		$top_jobs = Cache::remember('top_jobs', config('constant.cacheTime'), function() {
            return Job::where('status', 1)
            			->orderBy('_id desc')
            			->orderBy('quantity_user_follow desc')
                        ->offset(0)
                        ->take(config('constant.limitJob'))
                        ->get();
        });
        return $top_jobs;
	}
}