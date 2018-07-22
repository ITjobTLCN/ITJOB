<?php

namespace App\Traits\Job;

use App\Employers;
use App\Applications;
use MongoDB\BSON\UTCDateTime;
use Auth;
use App\Job;
use App\Follows;
use Carbon\Carbon;
use DateTime;
use App\Libraries\MongoExtent;

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
					->orderBy('_id', 'desc')
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
		if (is_null($job) || empty($job)) return [];

		$condition = [
			'_id' => [
				'$nin' => [MongoExtent::safeMongoId($job->_id)]
			],
			'status' => 1,
			'skills_id' => [
				'$in' => $job->skills_id
			]
		];

		return Job::with('employer')
				            ->where($condition)
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
            	$skill_id[] = $skill['_id'];
            }

            $arrInsert['skills_id'] = $skill_id;
        }

        if ( !empty($data['date_expired'])) {
            $substr = substr($data['date_expired'], 0, strpos($data['date_expired'], "("));
            $date_expired = (new DateTime($substr))->getTimestamp();

            $arrInsert['date_expired'] = new UTCDateTime($date_expired * 1000);
        }
        $this->formatInputToSave($arrInsert);

        return Job::insert($arrInsert);
	}

	protected function editJob($data, $empId, $skills, $jobId) {
		$job = Job::where('_id', $jobId)->first();

        $arrUpdate = [
        	'name' => !empty($data['name']) ? $data['name'] : $job['name'],
        	'alias' => $this->changToAlias($data['name']),
        	'detail' => [
        		'salary' => !empty($data['salary']) ? intval($data['salary']) : ($job['detail']['salary'] ?? 0),
        		'description' => !empty($data['description']) ? $data['description'] : ($job['detail']['description'] ?? ''),
        		'requirment' => !empty($data['requirment']) ? $data['requirment'] : ($job['detail']['requirment'] ?? ''),
        		'benefit' => !empty($data['benefit']) ? $data['benefit'] : ($job['detail']['benefit'] ?? ''),
        		'quantity' => !empty($data['quantity']) ? intval($data['quantity']) : ($job['detail']['quantity'] ?? 0),
        		'address' => !empty($data['address']) ? $data['address'] : ($job['detail']['address'] ?? ''),
        	],
        	'city' => !empty($data['city']) ? $data['city'] : $job['city'],
        ];
        $skill_id = [];
        if (sizeof($skills) > 0) {
            foreach($skills as $skill) {
            	$skill_id[] = $skill['_id'];
            }

            $arrUpdate['skills_id'] = $skill_id;
        } else {
			$arrUpdate['skills_id'] = [];
		}

        if ( !empty($data['date_expired'])) {
            $substr = substr($data['date_expired'], 0, strpos($data['date_expired'], "("));
            $date_expired = (new DateTime($substr))->getTimestamp();

            $arrUpdate['date_expired'] = new UTCDateTime($date_expired * 1000);
        }

        return Job::where('_id', $jobId)->update($arrUpdate);
	}
}
