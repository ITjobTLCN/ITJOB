<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = "permissions";

    public function Roles()
    {
    	return $this->belongsTo('App\Roles','role_id','id');
    }
}
