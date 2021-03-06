<?php

namespace App;

// use Illuminate\Notifications\Notifiable;
use App\Overrides\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Cache;

class User extends Eloquent implements Authenticatable
{
    use Notifiable,
        SoftDeletes,
        AuthenticableTrait;

    protected $collection = 'users';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function socialProviders() {
        return $this->hasMany(SocialProvider::class);
    }

    public function isOnline() {
        return Cache::has('user-is-online-'.$this->id);
    }

    public function roles() {
        return $this->belongsTo('App\Roles', 'role_id', '_id');
    }
}
