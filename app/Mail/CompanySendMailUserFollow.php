<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Employers;

class CompanySendMailUserFollow extends Mailable
{
    use Queueable, SerializesModels;
    private $arrUser;
    private $employer;
    private $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($arrUser, $employer, $post)
    {
        $this->arrUser = $arrUser;
        $this->employer = $employer;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = "<h3>New job for {$this->employer->name} on ITJobs.</h3>";
        $content = "<h1>{$this->post->name}</h1>";
        return $this->view('partials.email1')
                    ->with([
                        'title' => $title,
                        'contentemail' => $content,
                    ]);
    }
}
