<?php

namespace App\Traits\User;

use App\User;
use App\Job;
use Hash;
use Auth;

trait UserMethod {

	protected function insertUser($data) {
		$arrData = [
			'email' => $data['email'],
			'name' => $data['name'],
			'password' => Hash::make($data['password']),
			'role_id' => config('constant.roles.candidate'),
			'avatar' => 'default.jpg'
		];
		$this->formatInputToSave($arrData);
		$objUser = new User();
		try {
			return $objUser->insert($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}

	protected function listPostOfUser($empId) {
		$listPost = [];
		if (Auth::check()) {
			$arrWhere = [
				'user_id' => Auth::id(),
				'employer_id' => $empId,
			];
			$listPost = Job::with('applications')
	                      ->where($arrWhere)
	                      ->orderBy('_id', 'desc')
	                      ->get();
		}

        return $listPost;
	}
}