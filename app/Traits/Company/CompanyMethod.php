<?php

namespace App\Traits\Company;

use App\Employers;
use App\Follows;
use App\Job;
use MongoDB\BSON\UTCDateTime;
use Auth;

trait CompanyMethod
{
    public function storeReview($data, $empId) {
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

}