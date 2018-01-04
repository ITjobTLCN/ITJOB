<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow_employers extends Model
{
    protected $table="follow_employers";

    public function User()
     {
     	return $this->belongsTo('App\User','user_id','id');
     }
}
