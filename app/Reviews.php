<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
     protected $table='reviews';
     public function user(){
     	return $this->belongsTo('App\User','user_id','id');
     }
}
