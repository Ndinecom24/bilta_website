<?php

namespace App\Mail;

use App\Models\Bilta\ApprovalWorkflowStage;
use App\Models\Bilta\LeaveApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $stage;

    public function __construct(LeaveApplication $application, ApprovalWorkflowStage $stage)
    {
        $this->application = $application;
        $this->stage = $stage;
    }

    public function build()
    {
        return $this->subject('Leave Approval Required — ' . $this->application->user->name)
                    ->view('emails.leave-approval-request');
    }
}
