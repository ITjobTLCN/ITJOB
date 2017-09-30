<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
     protected $table='cv';

     public function User()
     {
     	return $this->belongsTo('App\User','user_id','id');
     }
     public function Jobs()
     {
     	return $this->belongsToMany('App\Jobs','applies','cv_id','job_id');
     }
}
