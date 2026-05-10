<?php

namespace App\Mail;

use App\Models\Bilta\LeaveApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $action;
    public $comment;
    public $actorName;
    public $stageName;

    public function __construct(LeaveApplication $application, string $action, ?string $comment, string $actorName, string $stageName)
    {
        $this->application = $application;
        $this->action = $action;
        $this->comment = $comment;
        $this->actorName = $actorName;
        $this->stageName = $stageName;
    }

    public function build()
    {
        $status = ucfirst($this->action);
        return $this->subject("Leave Application {$status} — {$this->stageName}")
                    ->view('emails.leave-status-update');
    }
}
