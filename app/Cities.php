<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Cities extends Eloquent
{
    use SoftDeletes;
    protected $collection = 'cities';
}
