<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
	protected $filltable=['provider_id','provider'];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
