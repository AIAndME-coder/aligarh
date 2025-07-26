<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;

    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle()
    {
        if ($this->phone) {
            \Illuminate\Support\Facades\Log::info('sms sent');

            // dd('SMS sent');

            // Use your SMS service here (e.g., Twilio)
            // \Log::info("SMS sent to {$this->phone}: {$this->message}");
        }
    }
}
