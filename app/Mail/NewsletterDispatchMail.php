<?php

namespace App\Mail;

use App\Models\Bilta\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterDispatchMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function build()
    {
        $mail = $this->subject($this->newsletter->title)
            ->view('emails.newsletter_dispatch');

        // Attach any PDFs from the media collection
        foreach ($this->newsletter->getMedia('newsletter_pdfs') as $media) {
            $mail->attach($media->getPath(), [
                'as' => $media->file_name,
                'mime' => $media->mime_type,
            ]);
        }

        return $mail;
    }
}
