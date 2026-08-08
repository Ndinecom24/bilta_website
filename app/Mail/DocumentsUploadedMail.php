<?php

namespace App\Mail;

use App\Models\Bilta\DocumentFolder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DocumentsUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $recipient;
    public User $uploader;
    public DocumentFolder $folder;
    public Collection $documents;
    public ?string $description;

    public function __construct(User $recipient, User $uploader, DocumentFolder $folder, Collection $documents, ?string $description = null)
    {
        $this->recipient = $recipient;
        $this->uploader = $uploader;
        $this->folder = $folder;
        $this->documents = $documents;
        $this->description = $description;
    }

    public function build()
    {
        return $this->subject('New document(s) uploaded: ' . $this->folder->name)
            ->view('emails.documents_uploaded');
    }
}
