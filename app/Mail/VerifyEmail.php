<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $verification_url;
    protected $user_name;
    protected $user_type;

    public function __construct($verification_url,$user_name,$user_type)
    {
        $this->verification_url = $verification_url;
        $this->user_name = $user_name;
        $this->user_type = $user_type;
    }

    public function build()
    {
        return $this->markdown('emails.emailVerificationEmail')
                    ->with('verification_url', $this->verification_url)
                    ->with('user_name', $this->user_name)
                    ->with('user_type', $this->user_type);
    }
}
