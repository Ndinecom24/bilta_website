<?php

namespace App\Mail;

use App\Models\Bilta\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnouncementNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function build()
    {
        $subject = ($this->announcement->priority === 'high' ? '[URGENT] ' : '')
            . ucfirst($this->announcement->type) . ': '
            . $this->announcement->title;

        return $this->subject($subject)
            ->view('emails.announcement_notification');
    }
}
