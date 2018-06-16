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
	protected function indexJob($wheres = []) {
		$arrWhere = [
			'status' => 1
		];
		if (!empty($wheres) || count($wheres) > 0) {
			$arrWhere = array_merge($arrWhere, $wheres);
		}

		return Job::with('employer')
					->where($arrWhere)
                    ->offset(0)
                    ->take(config('constant.limit.job'))
                    ->get();
	}

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
		if ($id) {
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

	protected function getJobsToday($empId) {
		$today = Carbon::now()->startOfDay();
		$arrWhere = [
			'employer_id' => $empId,
			'deleted' => false,
			'created_at' => [
				'$gt'  => $today->subDays(3),
				'$lte' => $today
			],
		];

		return Job::where($arrWhere)->get();
	}

	protected function getRelatedJob($job) {
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

	public function getJobsOfCompany($empId)
	{
		$arrWhere = [
			'employer_id' => $empId,
			'$or' => [
				[
					'status' => [
						'$in' => config('constant.statusJob')
					]
				]
			]
		];

		return Job::with('user', 'applications')
                     ->where($arrWhere)->get();
	}

	protected function saveJob($data, $empId, $skills) {
		$job = new Job();
		$job->name = $data['name'];
        $job->alias = $this->changToAlias($data['name']);
        $arrInsert = [
        	'name' => $data['name'],
        	'alias' => $this->changToAlias($data['name']),
        	'detail' => [
        		'salary' => !empty($data['salary']) ? intval($data['salary']) : 0,
        		'description' => !empty($data['description']) ? $data['description'] : '',
        		'requirment' => !empty($data['requirment']) ? $data['requirment'] : '',
        		'benefit' => !empty($data['benefit']) ? $data['benefit'] : '',
        		'quantity' => !empty($data['quantity']) ? intval($data['quantity']) : 0,
        		'address' => !empty($data['address']) ? $data['address'] : '',
        	],
        	'user_id' => Auth::id(),
        	'employer_id' => $empId,
        	'city' => $data['city']['name'],
        	'status' => 0 // 0:saving, 10: pending, 1: publisher, 11: expired, 2: deleted
        ];
        $skill_id = [];
        if (sizeof($skills) > 0) {
            foreach($skills as $skill) {
            	$skill_id[] = $skill['id'];
            }

            $arrInsert['skills_id'] = $skill_id;
        }

        if ( !empty($data['date_expire'])) {
            // $date = strtotime("Sun Jan 01 2017 08:00:00 GMT+0700 (Altai Standard Time)");
            //Loại bỏ cái trong ngoặc (Altai Standard Time)
            $substr = substr($data['date_expire'], 0, strpos($data['date_expire'], "("));
            $date = new DateTime($substr);
            $date2 = $date->getTimestamp(); //chuyển sang unix datetime
            $arrInsert['date_expired'] = $date2;
        }
        $this->formatInputToSave($arrInsert);

        return Job::insert($arrInsert);
	}
}