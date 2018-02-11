<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class SocialProvider extends Eloquent
{
    use SoftDeletes;

	protected $filltable=['provider_id','provider'];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
