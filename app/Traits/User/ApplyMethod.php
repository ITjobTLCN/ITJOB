<?php

namespace App\Traits\User;

use App\User;
use App\Job;
use App\Applications;
use App\Employers;
use Hash;
use MongoDB\BSON\UTCDateTime;
use Auth;
use File;
use Storage;
use App\Notifications\NotifyApplication;

trait ApplyMethod {
	protected function saveApplication($data) {
		$filename = "";
		if (!empty($data['cv'])) {
			if (!empty($data['new_cv'])) {
				$newCV = $data['new_cv'];
				$file_extension = File::extension($newCV->getClientOriginalName());
				$filename = 'cv-' . $this->changToAlias(Auth::user()->name) . '.' . $file_extension;

	           	$newCV->move('uploads/emp/cv/', $filename);
			} else {
				$cv = $data['cv'];
				if (!file_exists(public_path() . "/uploads/user/cv/{$cv}")) {
					$file_extension = File::extension($cv->getClientOriginalName());
					if (Auth::check()) {
						$filename = 'cv-' . $this->changToAlias(Auth::user()->name) . '.' . $file_extension;
					} else {
						$filename = 'CV' . time() . '.' . $file_extension;
					}

	            	$cv->move('uploads/emp/cv/', $filename);
	            } else {
	        		try {
	        			File::copy(public_path() . "/uploads/user/cv/{$cv}", public_path() . "/uploads/emp/cv/{$cv}");
				    	$filename = $cv;
	        		} catch(\Exception $ex) {
	        			return $ex->getMessages();
	        		}
	            }
			}
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
		$id = $objApplication->insertGetId($this->formatInputToSave($arrData));
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