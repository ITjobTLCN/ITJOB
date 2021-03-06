<?php

namespace App\Traits\Company;

use App\Employers;
use App\Follows;
use App\Job;
use App\Registration;
use App\Cities;
use MongoDB\BSON\UTCDateTime;
use Auth;
use Carbon\Carbon;

trait CompanyMethod
{
    protected function getCompanyWithUser($type) {
        if (!Auth::check()) {
            return;
        }

        $where = [
            '$or' => [
                ['employee' => ['$in' => [Auth::id()]]],
                ['master' => ['$in' => [Auth::id()]]]
            ]
        ];

        return Employers::with('city')
                        ->where($where)
                        ->first();
    }

    protected function storeReview($data, $empId) {
    	$objEmployer = new Employers();
    	$where = [
    		'_id' => $empId
    	];
    	$employer = Employers::where($where)->first();
    	if(empty($employer)) {
    		return response()->json([
	    		'message' => 'Not Found Company',
	    		'error' => true
    		], 404);
    	}
		$arrUpdate = [
			'title' => $data['title'],
			'like' => $data['like'],
			'unlike' => $data['unlike'],
			'suggest' => $data['suggest'],
			'recommend' => $data['recommend'],
			'rating' => intval($data['rating']),
			'reviewed_at' => new UTCDateTime(round(microtime(true) * 1000)),
			'reviewed_by' => Auth::user()->email
		];

		if($objEmployer->where($where)->push('reviews', $arrUpdate)) {
			$this->updateRating($empId, $data['rating']);

			return  response()->json([
			    		'message' => 'Save review successful',
			    		'error' => false
			    	], 200);
		}

		return response()->json([
    		'message' => 'Can NOT save review company',
    		'error' => true
    	], 500);
    }

    protected function updateRating($empId, $rating) {
    	$employer = new Employers();
    	$arrReviews = $employer->select('reviews', 'rating')
						    	->where('_id', $empId)
						    	->first();
    	$tempRating = floatval($arrReviews['rating']);
    	$quantiyReviews = count($arrReviews['reviews']);
    	//calculate avg rating
    	$avgRating = ((($tempRating * ($quantiyReviews - 1)) + intval($rating)) / $quantiyReviews);
    	$result = strval(number_format($avgRating, 1));

        return $employer->where('_id', $empId)
                		->update(['rating' => $result]);
    }

    protected function companyUpdateQuantityFollowed($empId, $deleted = false) {
        $deleted ? $amount = 1 : $amount = -1;
        try {
            $objEmployer = new Employers();
            $employer = Employers::find($empId);

            $nextFollow = intval($employer['quantity_user_follow'] + $amount);
            $objEmployer->where('_id', $empId)->update([
                'quantity_user_follow' => $nextFollow
            ]);
            return $nextFollow;
        } catch(\Exception $ex){}
    }

    protected function userSaveFollowCompany($empId) {
        $userId = Auth::id();
        $objFollow = new Follows();
        $where = [
            'user_id' =>  $userId,
            'followed_info' => [
                '_id' => $empId,
                'deleted' => true
            ]
        ];
        $objFollow = new Follows();
        $follow = $objFollow->where($where)->first();
        $data = [
            'user_id' =>  $userId,
            'followed_info' => [
                '_id' => $empId,
                'deleted' => false
            ],
            'type' => 'company'
        ];
        $data = $this->formatInputToSave($data);
        $id = $objFollow->insert($data);
        if($id) {
            $employer = Employers::find($empId);
            Employers::where('_id', $empId)->update([
                'quantity_user_follow' => intval($employer['quantity_user_follow'] + 1)
            ]);
        }
        return false;
    }

    protected function saveEmployer($data) {
         $emp = new Employers();
         $city = Cities::where('_id', $data['city_id'])->first();
         $arrInsert = [
            'name' => $data['name'],
            'alias' => $this->changToAlias($data['name']),
            'city_id' => $data['city_id'],
            'address' => [
                [
                    '_id' => $data['city_id'],
                    'city' => $city['name'],
                    'detail' => $data['address'][0]['detail']
                ]
            ],
            'info' => [
                'website' => $data['website'],
            ],
            'quantity_user_follow' => 0,
            'rating' => "0.0",
            'skills' => [],
            'quantity_job' => [
                'hirring' => 0,
                'deleted' => 0
            ],
            'status' => 0,
            'images' => [
                'cover' => 'house.png',
                'avatar' => 'house.png',
                'details' => []
            ],
            'master' => [Auth::id()],
            'employee' => []
        ];
        try {
            return $emp->insertGetId($this->formatInputToSave($arrInsert));
        } catch(\Exception $e) {}
    }

    protected function saveRegisterEmployer($data = []) {
        $res = new Registration();
        $arrInsert = [
            'user_id' => Auth::id(),
            'emp_id' => $data['emp_id'],
            'status' => $data['type']
        ];

        try {
            $this->formatInputToSave($arrInsert);
            $res->insert($arrInsert);

            // $where = [
            //     '_id' => $data['emp_id']
            // ];
            // $objEmployer = Employers::where($where)->first();
            // if ( !empty($objEmployer)) {
            //     $employee = $objEmployer['employee'] ?? [];
            //     array_push($employee, Auth::id());
            //     $arrUpdate = [
            //         'employee' => $employee
            //     ];
            //     return Employers::where($where)->update($arrUpdate);
            // }
        } catch(\Exception $ex) {
            return false;
        }

        return true;
    }

    protected function getJobOfByCompany($empId = null) {
        if (is_null($empId) || empty($empId)) {
            return;
        }

        $arrWhere = [
            'employer_id' => $empId,
            'status' => [
                '$in' => [1, 11]
            ]
        ];
        $listJob = Job::with('user', 'applications')
                        ->where($arrWhere)
                        ->get();

        return $listJob;
    }

    protected function getReviewOfCompany($empId = null) {
        if (is_null($empId) || empty($empId)) {
            return;
        }

        $employer = Employers::where('_id', $empId)->first();
        if (empty($employer['reviews'])) {
            return;
        }

        return $employer['reviews'];
    }

    protected function getReviewTodayOfCompany($empId = null, $today = null) {
        if ( is_null($today)) {
            return;
        }

        $arrWhere = [
            '_id' => $empId,
            'reviews' => [
                'reviewed_at' => [
                    '$gte' => $today->subDays(3)
                ]
            ],
        ];
        $result = [];
        $listReview = Employers::where($arrWhere)->first();
        if (empty($listReview)) {
            return [];
        }

        foreach ($listReview as $key => $item) {
            $result[] = $item['reviews'];
        }

        return $result;
    }

    protected function getFollow($empId) {
        if (is_null($empId) || empty($empId)) {
            return;
        }

        $result = [];
        $arrWhere = [
            'type' => 'company',
            'followed_info' => [
                '_id' => $empId,
                'deleted' => false
            ]
        ];

        $listFollowed = Follows::with('user')
                                ->where($arrWhere)
                                ->get();
        if ( !empty($listFollowed)) {
            $result = $listFollowed;
        }

        return $result;
    }

    protected function getCompanyHirring($offset = 0, $limit = null) {
        $arrWhere = [
            'quantity_job.hirring' => [
                '$gt' => 0
            ],
            'status' => 1
        ];
        $this->formatCondition($arrWhere);
        return Employers::where($arrWhere)
                                ->orderBy('_id', 'desc')
                                ->offset($offset)
                                ->limit($limit)
                                ->get();
    }

    protected function getCompanyMostFollow($offset = 0, $limit = null) {
        $arrWhere = [
            'status' => 1
        ];
        $this->formatCondition($arrWhere);

        return Employers::where($arrWhere)
                                ->orderBy('quantity_user_follow', 'desc')
                                ->offset($offset)
                                ->limit($limit)
                                ->get();
    }

    protected function updateInfoCompany($data, $empId) {
        $objEmployer = Employers::where('_id', $empId)->first();
        if (empty($objEmployer)) {
            return response()->json(['status' => false,
                                        'message' => 'Cannot Found Company']);
        }

        $arrAddress = array_where($objEmployer['address'], function ($value, $key) use ($objEmployer) {
                return $value['_id'] !== $objEmployer['city_id'];
        });

        $addressUpdate = [
            '_id' => $objEmployer['city_id'],
            'city_id' => $data['city'],
            'detail' => $data['address']
        ];
        array_unshift($arrAddress, $addressUpdate);

        $arrUpdate = [
            'name' => $data['name'],
            'info' => [
                'website' => $data['website'],
                'description' => $data['description'],
                'phone' => $data['phone']
            ],
            'schedule' => $data['schedule'],
            'skills' => $data['skills'],
            'address' => $arrAddress
        ];

        return Employers::where('_id', $empId)->update($arrUpdate);
    }

    protected function sendMailToUserFollow($empId, $post) {
        $where = [
            'type' => 'company',
            'followed_info' => [
                '_id' => $empId,
                'deleted' => false
            ]
        ];
        $userFollow = Follows::where($where)->get();
        if (empty($userFollow)) return;
        dispatch(new \App\Jobs\CompanySendMailUserFollow($userFollow, $empId, $post));
    }
}
