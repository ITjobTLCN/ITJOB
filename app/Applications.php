<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Applications extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $collection = "applications";
}
