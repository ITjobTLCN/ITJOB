<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employers extends Model
{
     protected $table='employers';
     public function city(){
     	return $this->belongsTo('App\Cities','city_id','id');
     }
}
