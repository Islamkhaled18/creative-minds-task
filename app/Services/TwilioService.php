<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $twilioPhone;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->twilioPhone = config('services.twilio.phone');

        if (!$sid || !$token) {
            throw new Exception('Twilio credentials not configured');
        }

        $this->client = new Client($sid, $token);
    }

    public function sendVerificationSMS(string $phoneNumber, string $code): bool
    {
        try {
            $message = $this->client->messages->create(
                $phoneNumber,
                [
                    'from' => $this->twilioPhone,
                    'body' => "Your verification code is: $code"
                ]
            );

            Log::info('SMS sent successfully', [
                'message_sid' => $message->sid,
                'phone' => $phoneNumber
            ]);
            return true;
        } catch (Exception $e) {
            Log::error('Failed to send SMS', [
                'exception' => $e->getMessage(),
                'code' => $e->getCode(),
                'phone' => $phoneNumber,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}
