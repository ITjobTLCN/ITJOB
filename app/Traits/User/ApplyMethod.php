<?php

namespace App\Traits\User;

use App\User;
use App\Job;
use App\Applications;
use Hash;
use MongoDB\BSON\UTCDateTime;
use Auth;

trait ApplyMethod {
	protected function saveApplication($data) {
		$filename = "";
		if (!empty($data['new_cv'])) {
            $cv = $data['new_cv'];
            $filename = $cv->getClientOriginalName();
            $cv->move('uploads/emp/cv/', $filename);
        }

		$arrData = [
			'user_id' => Auth::check() ? Auth::id() : 0,
			'job_id' => $data['job_id'],
			'fullname' => $data['fullname'],
			'email' => $data['email'],
			'note' => $data['note'],
			'cv' => $filename,
			'created_at' => new UTCDateTime(round(microtime(true) * 1000))
		];
		$job = Job::where('_id', $data['job_id'])->first();
		if ( !empty($job)) {
			$arrData['employer_id'] = $job['employer_id'];
		}
		$objApplication = new Applications();
		$id = $objApplication->insert($this->formatInputToSave($arrData));
       	if ( !empty($id)) {
       		return  response()->json([
		    		'message' => 'Save application successful',
		    		'error' => false
		    	], 200);
       	}

        return  response()->json([
			    		'message' => 'Can NOT Save application',
			    		'error' => true
			    	], 500);
	}

	public function getApplicationByCompany($empId = null, $today = null) {
		if (is_null($empId) || empty($empId)) return;
		$arrWheres = [
			'employer_id' => $empId,
			'deleted' => false
		];
		if ( !is_null($today)) {
			$arrWheres['created_at'] = [
				'$lte' => $today
			];
		}

		return Applications::where($arrWheres)->get();
	}
}