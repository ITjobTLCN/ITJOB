<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use DateTime;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        /*Update lastlogin when login or logout*/
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        //send mail when register
        'App\Events\SendMail' => [
            'App\Listeners\SendMailRegister',
        ],
        'App\Events\SendMailContact' => [
            'App\Listeners\SendMailContacts'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Event::listen('auth.login',function($user){
        //     $user->lastlogin = new DateTime;
        //     $user->save();  
        // });
        //
    }
}
