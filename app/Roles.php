<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Roles extends Eloquent
{
    use SoftDeletes;

   protected $collection = "roles";

   public function User()
   {
   		return $this->hasMany('App\User','role_id','id');
   }

   //To export data using Excel
   protected $fillable=['name','detail'];
}
