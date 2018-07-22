<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Registration extends Eloquent
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $collection = 'registration';

    protected $primaryKey = ('user_id');

    public function user() {
    	return $this->belongsTo('App\User','user_id','_id');
    }

    public function employer() {
    	return $this->belongsTo('App\Employers','emp_id','_id');
    }
}
