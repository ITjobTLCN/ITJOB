<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Notifications extends Eloquent
{
    use SoftDeletes;
    protected $collection = 'notifications';
}
