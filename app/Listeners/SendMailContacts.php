<?php

namespace App\Listeners;

use App\Events\SendMailContact;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class SendMailContacts
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMailContact  $event
     * @return void
     */
    public function handle(SendMailContact $event)
    {
        dd($event->email);
        Mail::send('partials.contact-mail', array('content' => $event->content, 
                                            'email' => $event->email,
                                            'name' => $event->name), function($message) use ($event){
            $message->to('itjobchallenge@gmail.com', 'ITJOB')->subject($event->subtitle);
        });
    }
}
