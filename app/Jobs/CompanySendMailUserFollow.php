<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\User;
use App\Employers;

class CompanySendMailUserFollow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $arrUser;
    private $empId;
    private $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arrUser, $empId, $post)
    {
        $this->arrUser = $arrUser;
        $this->empId = $empId;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $employer = Employers::where('_id', $this->empId)->first();
        $email = new \App\Mail\CompanySendMailUserFollow($this->arrUser, $employer, $this->post);
        foreach ($this->arrUser as $key => $value) {
            $user = User::find($value['user_id']);
            Mail::to($user->email)->send($email);
        }

        \Log::info('Send mail to user followed company successfully');
    }
}
