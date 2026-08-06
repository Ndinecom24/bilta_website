<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;
    public $resetBy;

    public function __construct(User $user, string $otp, string $resetBy)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->resetBy = $resetBy;
    }

    public function build()
    {
        return $this->subject('Password Reset — Your One-Time Password')
            ->view('emails.password-reset-otp');
    }
}
