<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailInterview extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $content)
    {
        $this->email = $email;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'THƯ MỜI PHỎNG VẤN - ITJOB';
        return $this->view('partials.email1')
                    ->with([
                        'title' => $title,
                        'contentemail' => $this->content,
                    ]);
    }
}
