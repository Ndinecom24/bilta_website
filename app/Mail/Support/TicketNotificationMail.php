<?php

namespace App\Mail\Support;

use App\Models\Support\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * One parameterised mail for every ticket event (new, assigned, status, comment ...).
 */
class TicketNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $headline;
    public $body;
    public $actorName;

    public function __construct(Ticket $ticket, string $headline, ?string $body = null, ?string $actorName = null)
    {
        $this->ticket = $ticket;
        $this->headline = $headline;
        $this->body = $body;
        $this->actorName = $actorName;
    }

    public function build()
    {
        return $this->subject('[' . $this->ticket->reference . '] ' . $this->headline)
            ->view('emails.support-ticket', [
                'url' => route('admin.support.show', $this->ticket->id),
            ]);
    }
}
