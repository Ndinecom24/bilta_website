<?php

namespace App\Mail;

use App\Models\SponsorInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(SponsorInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('New Sponsorship Inquiry')
            ->view('emails.sponsor_inquiry');
    }
}
