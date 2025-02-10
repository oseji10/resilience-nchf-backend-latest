<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SMSService; // Make sure you have an SMS sending service

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $smsMessage;

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $smsMessage)
    {
        $this->phone = $phone;
        $this->smsMessage = $smsMessage;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Call your SMS service to send the message
        $smsService = new SMSService();
        $smsService->sendSMS($this->phone, $this->smsMessage);
    }
}
