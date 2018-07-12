<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Access_log extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $collection = 'access_log';

}
