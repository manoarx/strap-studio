<?php

namespace App\Listeners;

use App\Events\SmsNotificationSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SmsNotificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SmsNotificationSent $event)
    {
        // Check the success status and perform actions accordingly
        if ($event->success) {
            // SMS successfully sent
            info("SMS to {$event->phoneNumber} was successfully sent.");
        } else {
            // SMS sending failed
            error("Failed to send SMS to {$event->phoneNumber}.");
        }
    }
}
