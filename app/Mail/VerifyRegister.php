<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
class VerifyRegister extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Đăng ký thành công tài khoản ITJOB';
        $content = '<h2>Chúc mừng bạn đã đăng ký thành công tài khoản ITJOB. Thông tin tài khoản như sau:</h2><br><h3>Email: '.$this->user->email.'</h3><br><h3>Mật khẩu: '.$this->user->password.'</h3>';
        return $this->view('partials.email1')
                    ->with([
                        'title'=>$title,
                        'contentemail'=> $content,
                    ]);
    }
}
