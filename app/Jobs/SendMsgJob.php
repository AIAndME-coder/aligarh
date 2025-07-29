<?php

namespace App\Jobs;

use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Jobs\SendWhatsAppJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMsgJob implements ShouldQueue
{
    public $emailSubject, $notificationsSettings;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $email, public $sms_number, public $whatsapp_number, public $message)
    {
       $this->emailSubject = 'Email from '.config('systemInfo.general.name');
       $this->notificationsSettings = collect([
        'sms' => 1,
        'mail' => 1,
        'whatsapp' => 1,
       ]);
    }

    public function handle()
    {
        if ($this->sendOn('mail'))
        {
            SendMailJob::dispatch($this->email, $this->message, $this->emailSubject);
        }
        if ($this->sendOn('sms'))
        {
            SendSmsJob::dispatch($this->sms_number, $this->message);
        }
            // case 'whatsapp':
            //     SendWhatsAppJob::dispatch($this->whatsapp_number, $this->message);
            //     break;
    }

    private function sendOn($type)
    {
        return $this->notificationsSettings[$type];
    }
}
