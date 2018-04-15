<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Employers extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $collection = 'employers';
     
    public function city() {
        return $this->belongsTo('App\Cities','city_id','id');
    }
    public function registrations() {
        return $this->hasMany('App\Registration','emp_id','id');
    }

    public function job() {
        return $this->hasMany('job');
    }
    // public function skills() {
    //     return $this->belongsToMany('App\Skills', 'skills', '_id');
    // }
}
