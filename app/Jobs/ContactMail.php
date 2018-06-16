<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use Auth;
class ContactMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $name;
    private $subtitle;
    private $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $subtitle, $content)
    {
        $this->email = $email;
        $this->name = $name;
        $this->subtitle = $subtitle;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new \App\Mail\SendContactMail($this->email, $this->name, $this->subtitle, $this->content);
        Mail::to('phong.kelvin1608@gmail.com')->send($email);

        \Log::info('Send mail successfully', [$this->email]);
    }
}
