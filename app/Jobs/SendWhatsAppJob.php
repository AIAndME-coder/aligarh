<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $whatsapp_number;
    protected $message;

    public function __construct($whatsapp_number, $message)
    {
        $this->whatsapp_number = $whatsapp_number;
        $this->message = $message;
    }

    public function handle()
    {
        if ($this->whatsapp_number) {
            \Illuminate\Support\Facades\Log::info('WhatsApp sent');

            // Use WhatsApp API here
            // \Log::info("WhatsApp message to {$this->whatsapp_number->whatsapp}: {$this->message}");
        }
    }
}
