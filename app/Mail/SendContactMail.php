<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $email;
    protected $name;
    protected $subtitle;
    protected $content;
    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Thông tin phản hồi ITJOB';
        $content = $this->content;
        return $this->view('partials.email1')
                    ->with([
                        'title' => $this->subtitle,
                        'contentemail' => $content,
                    ]);
    }
}
