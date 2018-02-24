<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Job extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    private $id;
    protected $collection = 'job';
    protected $fillable = [
        "name","alias","user_id","emp_id","city_id"
    ];
    public function CV()
    {
        return $this->belongsToMany('App\CV','applies','job_id','cv_id');
    }
    public function Cities()
    {
        return $this->belongsTo('App\Cities','city_id','id');
    }
    public function Employer()
    {
        return $this->belongsTo('App\Employers','emp_id','id');
    }
    public function User()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function Applications(){
        return $this->hasMany('App\Applications','job_id','id');
    }
    public function __toString(){
        return $this->id;
    }
}
