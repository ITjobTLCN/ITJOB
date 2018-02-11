<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Skills extends Eloquent
{
    use SoftDeletes;

     protected $collection = 'skills';

     public function Jobs()
     {
     	return $this->belongsToMany('App\Jobs','skill_job','skill_id','job_id');
     }
}
