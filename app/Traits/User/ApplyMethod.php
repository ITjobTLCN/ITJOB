<?php

namespace App\Traits\User;

use App\User;
use App\Job;
use App\Applications;
use App\Employers;
use Hash;
use MongoDB\BSON\UTCDateTime;
use Auth;
use App\Notifications\NotifyApplication;

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
			'enable' => true,
		];
		$job = Job::where('_id', $data['job_id'])->first();
		if ( !empty($job)) {
			$arrData['employer_id'] = $job['employer_id'];
		}
		$objApplication = new Applications();
		$id = $objApplication->insert($this->formatInputToSave($arrData));
       	if ( !empty($id)) {
       		// send notify to owners of post
       		$employer = Employers::where('_id', $job['employer_id'])->first();
       		$master = $employer['master'];
       		$employee = $employer['employee'];
       		$arrUser = array_merge($master, $employee);
       		foreach ($arrUser as $id) {
       			$user = User::where('_id', $id)->first();
       			$user->notify(new NotifyApplication($job, Auth::check() ? Auth::id() : 0));
       		}

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
				'$gte' => $today->subDays(2)
			];
		}

		return Applications::with('job')->where($arrWheres)->get();
	}
}