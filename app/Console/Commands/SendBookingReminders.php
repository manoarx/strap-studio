<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:booking-reminders';
    protected $description = 'Send booking reminders 24 hours before the booked date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bookedItems = OrderItem::whereDate('booked_date', '=', now()->addDay()->toDateString())
            ->get();

        foreach ($bookedItems as $item) {
            $this->sendReminder($item);
        }
    }

    private function sendReminder($orderItem)
    {
        if ($orderItem->order->user->phone) {
            try {
                $sms = app('smsglobal');
                $userPhoneNumber = $orderItem->order->user->cn_code . $orderItem->order->user->phone;
                $destinationNumber = $this->normalizePhoneNumber($userPhoneNumber);

                $message = 'Hi ' . $orderItem->order->user->name . ', Just confirming your appointment on ' . $orderItem->booked_date . ' at ' . $orderItem->booked_stime . '. Looking forward to arrive for the shoot 15 minutes prior to time. Let us know if there are any changes.';

                $response = $sms->sendToOne($destinationNumber, $message, 'STRAPSTUDIO');

                Log::info('SMS Global API Response', [
                    'response' => [
                        'Messages' => $response['messages'],
                    ],
                ]);
            } catch (\Exception $e) {
                Log::error('SMS Global API Response', [
                    'response' => [
                        'Error' => $e->getMessage(),
                        'Code' => $e->getCode(),
                    ],
                ]);
            }
        }
    }

    public function normalizePhoneNumber($phoneNumber) {
        // Remove any non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If the number starts with '0', remove it
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // If the number doesn't start with the country code, add '971'
        // if (substr($phoneNumber, 0, 3) !== '971') {
        //     $phoneNumber = '971' . $phoneNumber;
        // }

        return $phoneNumber;
    }
}
