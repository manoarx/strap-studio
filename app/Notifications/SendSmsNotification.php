<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SalamWaddah\SmsGlobal\SmsGlobalChannel;
use SalamWaddah\SmsGlobal\SmsGlobalMessage;

class SendSmsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['mail'];
        return [
            SmsGlobalChannel::class,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toSmsGlobal(string $phoneNumber): SmsGlobalMessage
    {
        $message = 'Order paid, Thank you for your business!';

        $smsGlobalMessage = new SmsGlobalMessage();

        // Set the phone number and content
        $smsGlobalMessage->to($phoneNumber)->content($message);

        // No need to explicitly send in this case, Laravel will handle it through the channel

        return $smsGlobalMessage;
    }
}
