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
            return Job::with('employer')
                        ->where('status', 1)
            			->orderBy('_id desc')
            			->orderBy('quantity_user_follow desc')
                        ->offset(0)
                        ->take(config('constant.limitJob'))
                        ->get();
        });
        return $top_jobs;
	}

    private function getListJobLatest() {
        if(Cache::has('listJobLastest')) {
            $listJobLastest = Cache::get('listJobLastest', '');
        } else {
            $selects = [
                'name', 'alias', 'city', 'employer', 'skills', 'expired', 'employer_id'
            ];
            $listJobLastest = Job::with('employer')->select($selects)->where('status', 1)
                                                    ->orderBy('_id', 'desc')
                                                    ->offset(0)
                                                    ->take(config('constant.limitJob'))
                                                    ->get();
            Cache::put('listJobLastest', $listJobLastest, config('constant.cacheTime'));
        }
    }
}