<?php

namespace App\Traits\User;

use App\User;
use App\Statistic_by_day;
use App\Statistic_by_month;
use App\Job;
use App\Access_log;
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

	/**
     * Save data login in access log table
     * @param string $user_id id of current user login
     * @return void
     */
	protected function insertAccessLog($user_id) {
		$arrData = [
			'user_id' => $user_id
		];
		$arrData = $this->formatInputToSave($arrData);
		$obj = new Access_log();
		try {
			return $obj->insert($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}

	/**
     * Save data Daily active user into statistic_by_day table
     * @param string $user_id id of current user login
     * @return void
     */
	protected function insertStatisticByDay($data) {
		$arrData = [
			'date' => $data['date'],
			'num_of_user' => !empty($data['num_of_user']) ? $data['num_of_user'] : 0,
			'num_of_post' =>!empty($data['num_of_post']) ? $data['num_of_post'] : 0,
			'num_of_application' => !empty($data['num_of_application']) ? $data['num_of_application'] : 0
		];
		$this->formatInputToSave($arrData);
		$obj = new Statistic_by_day();
		try {
			return $obj->insert($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}

	/**
     * Update data Daily active user into statistic_by_day table
     * @param string $user_id id of current user login
     * @return void
     */
	protected function updateStatisticByDay($_id, $data) {

		$arrData = array();
		if (isset($data['num_of_user'])) {
			$arrData['num_of_user'] =  $data['num_of_user'];
		}
		if (isset($data['num_of_post'])) {
			$arrData['num_of_post'] =  $data['num_of_post'];
		}
		if (isset($data['num_of_application'])) {
			$arrData['num_of_application'] =  $data['num_of_application'];
		}


		// Update updated_at field
		$this->formatInputToUpdate($arrData);
		$obj = new Statistic_by_day();
		try {
			return $obj->where('_id', $_id)->update($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}

	/**
     * Save data Daily active user into statistic_by_month table
     * @param string $user_id id of current user login
     * @return void
     */
	protected function insertStatisticByMonth($data) {
		$arrData = [
			'month' => $data['month'],
			'year' => $data['year'],
			'num_of_user' => !empty($data['num_of_user']) ? $data['num_of_user'] : 0,
			'num_of_post' =>!empty($data['num_of_post']) ? $data['num_of_post'] : 0,
			'num_of_application' => !empty($data['num_of_application']) ? $data['num_of_application'] : 0
		];
		$this->formatInputToSave($arrData);
		$obj = new Statistic_by_month();
		try {
			return $obj->insert($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}

	/**
     * Update data Daily active user into statistic_by_month table
     * @param string $user_id id of current user login
     * @return void
     */
	protected function updateStatisticByMonth($_id, $data) {

		$arrData = array();
		if (isset($data['num_of_user'])) {
			$arrData['num_of_user'] =  $data['num_of_user'];
		}
		if (isset($data['num_of_post'])) {
			$arrData['num_of_post'] =  $data['num_of_post'];
		}
		if (isset($data['num_of_application'])) {
			$arrData['num_of_application'] =  $data['num_of_application'];
		}


		// Update updated_at field
		$this->formatInputToUpdate($arrData);
		$obj = new Statistic_by_month();
		try {
			return $obj->where('_id', $_id)->update($arrData);
		} catch(\Exception $e) {
			return $e->getMessage();
		}

		return false;
	}
}
