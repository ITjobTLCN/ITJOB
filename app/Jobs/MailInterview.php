<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class MailInterview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $content;
    private $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($content, $email)
    {
        $this->content = $content;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new \App\Mail\SendMailInterview($this->email, $this->content);
        Mail::to($this->email)->send($email);
        
        \Log::info('Send mail successfully', [$this->email]);
    }
}
