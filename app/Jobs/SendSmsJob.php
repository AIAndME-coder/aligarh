<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        if (!$this->phone || !$this->message) {
            return;
        }

        $config = config('systemInfo.sms');

        $response = Http::asForm()->post(rtrim($config['url'], '/') . '/plain', [
            'api_token'  => $config['api_token'],
            'api_secret' => $config['api_secret'],
            'to'         => $this->phone,
            'from'       => $config['sender'],
            'message'    => $this->message,
        ]);

        if ($response->successful() && str_contains($response->body(), 'OK')) {
            Log::info('✅ SMS sent successfully to ' . $this->phone);
        } else {
            Log::error('❌ SMS failed', [
                'to' => $this->phone,
                'message' => $this->message,
                'response' => $response->body(),
                'status' => $response->status(),
            ]);
        }
    }
}
