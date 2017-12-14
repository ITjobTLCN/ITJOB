<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employers extends Model
{
     protected $table='employers';
     public function city(){
     	return $this->belongsTo('App\Cities','city_id','id');
     }
     public function registrations(){
     	return $this->hasMany('App\Registration','emp_id','id');
     }
}
