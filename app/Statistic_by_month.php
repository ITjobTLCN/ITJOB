<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Statistic_by_month extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $collection = 'statistic_by_month';

}
