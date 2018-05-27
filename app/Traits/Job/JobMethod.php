<?php

namespace App\Traits\Job;

use App\Employers;
use App\Applications;
use MongoDB\BSON\UTCDateTime;
use Auth;
use App\Job;
use App\Follows;
use Carbon\Carbon;

trait JobMethod
{
	protected function checkUserAlreadyApply($email, $jobId) {
		$arrWhere = [
			'_id' => $jobId,
			'apply_info' => [
				'email' => $email
			]
		];
		$temp = Job::where($arrWhere)->first();
        if (!empty($temp)) {
        	return response()->json([
        		'error' => true,
        		'message' => 'Bạn đã apply công việc này rồi'
        	], 500);
    	}
	}

	protected function userSaveFollowJob($userId, $jobId) {
		$objFollow = new Follows();
		$where = [
            'user_id' => $userId,
            'followed_info' => [
                '_id' => $jobId,
                'deleted' => true
            ]
        ];
        $objFollow = new Follows();
        $follow = $objFollow->where($where)->first();
		$data = [
			'user_id' => $userId,
			'followed_info' => [
                '_id' => $jobId,
                'deleted' => false
            ],
            'type' => 'job'
		];
		$data = $this->formatInputToSave($data);
		$id = $objFollow->insert($data);
		if($id) {
			$job = Job::find($jobId);
			Job::where('_id', $jobId)->update([
				'quantity_user_follow' => intval($job['quantity_user_follow'] + 1)
			]);
		}
		return false;
	}

	protected function jobUpdateQuantityFollowed($jobId, $deleted = false) {
		$deleted ? $amount = 1 : $amount = -1;
		$objJob = new Job();
		try {
			$job = Job::find($jobId);
			$objJob->where('_id', $jobId)->update([
	            'quantity_user_follow' => intval($job['quantity_user_follow'] + $amount)
        	]);
		} catch(\Exception $ex){}
	}

	protected function getCompanyByJob($jobId = null) {
		if (is_null($jobId) || empty($jobId)) {
			return;
		}

		return Job::select('employer_id')->where('_id', $jobId)->first();
	}

	protected function getJobsToday($empId)
	{
		$today = Carbon::now()->startOfDay();
		$arrWhere = [
			'employer_id' => $empId,
			'deleted' => false,
			'created_at' => [
				'$lte' => $today
			]
		];

		$objJob = new Job();
		$objJob = Job::where($arrWhere)->get();

		return $objJob;
	}

	protected function getRelatedJob($job)
	{
		if (is_null($job) || empty($job)) {
			return [];
		}

		return Job::with('employer')
				            ->where('_id', '!=', $job->_id)
				            ->whereIn('skills_id', $job->skills_id)
				            ->offset(0)
				            ->take(config('constant.limit.relatedJob'))
				            ->get();
	}
}