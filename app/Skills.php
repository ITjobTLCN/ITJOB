<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
     protected $table='skills';

     public function Jobs()
     {
     	return $this->belongsToMany('App\Jobs','skill_job','skill_id','job_id');
     }
}
