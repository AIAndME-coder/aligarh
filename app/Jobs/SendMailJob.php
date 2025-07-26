<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $message;

    public function __construct($email, $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    public function handle()
    {
        if ($this->email) {

            \Illuminate\Support\Facades\Log::info('email sent');
            // dd('email sent');
            Mail::raw($this->message, function ($mail) {
                $mail->to($this->email)
                     ->subject('Notification');
            });
        }
    }
}
