<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Applications extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $collection = "applications";

    public function employer() {
        return $this->belongsTo('App\Employers','employer_id','_id');
    }

    public function job() {
    	return $this->belongsTo('App\Job', 'job_id', '_id');
    }
}
