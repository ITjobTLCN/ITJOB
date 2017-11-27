<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    //
    protected $table="registration";

    protected $primaryKey = ('emp_id');
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function employer(){
    	return $this->belongsTo('App\Employers','emp_id','id');
    }
}
