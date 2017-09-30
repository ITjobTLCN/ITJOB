<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
   protected $table = "roles";

   public function Permission()
   {
   		return $this->hasMany('App\Permissions','role_id','id');
   }
   public function User()
   {
   		return $this->hasMany('App\User','role_id','id');
   }
}
