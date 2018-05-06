<?php

namespace App\Traits\User;

use App\User;
use Hash;

trait UserMethod {

	protected function insertUser($data)
	{
		$arrData = [
			'email' => $data['email'],
			'name' => $data['name'],
			'password' => Hash::make($data['password']),
			'role_id' => 1,
			'avatar' => 'default.jpg'
		];
		$objUser = new User();

		try {
			$this->formatInputToSave($arrData);
			$objUser->insert($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}

}