<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Cache;

class User extends Eloquent implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Notifiable, Authenticatable, SoftDeletes, Authorizable;
    protected $collection = "users";

    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function Roles()
    {
       return $this->belongsTo('App\Roles','role_id','id');
    }
    public function Employers()
    {
        return $this->belongsTo('App\Employers','company_id','id');
    }
    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
    public function isOnline(){
        return Cache::has('user-is-online-'.$this->id);
    }
}
