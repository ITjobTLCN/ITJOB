<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Employers extends Eloquent
{
    use SoftDeletes;

     protected $collection = 'employers';
     public function city() {
     	return $this->belongsTo('App\Cities','city_id','id');
     }
     public function registrations() {
     	return $this->hasMany('App\Registration','emp_id','id');
     }
}
