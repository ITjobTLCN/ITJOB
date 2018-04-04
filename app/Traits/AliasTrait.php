<?php

namespace App\Traits;
use App\Cities;
use App\Job;
use App\Employers;
use App\Skills;
use Session;

trait AliasTrait
{
	public function getCityByKey($key) {
    	return Cities::where('name', $key)->orWhere('alias', $key)->first();
    }
    public function getJobByKey($key) {
    	return Job::where('name', $key)->orWhere('alias', $key)->first();
    }
    public function getEmployerByKey($key) {
    	return Employers::where('name', $key)->orWhere('alias', $key)->first();
    }
    public function getSkillByKey($key) {
    	return Skills::where('name', $key)->orWhere('alias', $key)->first();
    }
}