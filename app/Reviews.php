<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
     protected $table='reviews';

     public function Employers()
     {
     	return $this->belongsTo('App\Employers','emp_id','id');
     }
}
