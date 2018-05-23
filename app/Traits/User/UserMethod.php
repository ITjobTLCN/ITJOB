<?php

namespace App\Traits\User;

use App\User;
use App\Job;
use Hash;

trait UserMethod {

	protected function insertUser($data)
	{
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
}