<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;

class User extends Authenticatable
{
    use Notifiable;

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
