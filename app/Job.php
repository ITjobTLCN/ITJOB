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
        "name", "alias", "user_id", "emp_id", "city_id"
    ];
    public function cv()
    {
        return $this->belongsToMany('App\CV','applies','job_id','cv_id');
    }
    public function cities()
    {
        return $this->belongsTo('App\Cities','city_id','id');
    }
    public function employer()
    {
        return $this->belongsTo('App\Employers','employer_id','_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    // public function skills() {
    //     return $this->belongsToMany('App\Skills');
    // }
    public function applications(){
        return $this->hasMany('App\Applications','job_id','id');
    }
    public function __toString(){
        return $this->id;
    }
}
