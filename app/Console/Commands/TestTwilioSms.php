<?php

namespace App\Console\Commands;

use App\Services\TwilioService;
use Illuminate\Console\Command;

class TestTwilioSms extends Command
{
    protected $signature = 'twilio:test {phone}';
    protected $description = 'Test Twilio SMS functionality';

    public function handle(TwilioService $twilioService)
    {
        $phone = $this->argument('phone');
        $code = rand(100000, 999999);

        $this->info("Sending test SMS to $phone with code $code");

        $result = $twilioService->sendVerificationSMS($phone, $code);

        if ($result) {
            $this->info('SMS sent successfully!');
            return Command::SUCCESS;
        } else {
            $this->error('Failed to send SMS. Check logs for more details.');
            return Command::FAILURE;
        }
    }
}
