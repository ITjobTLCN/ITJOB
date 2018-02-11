<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Reviews extends Eloquent
{
    use SoftDeletes;

     protected $collection = 'reviews';
     public function user(){
     	return $this->belongsTo('App\User','user_id','id');
     }
}
