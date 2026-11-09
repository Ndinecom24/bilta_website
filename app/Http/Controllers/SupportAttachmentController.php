<?php

namespace App\Http\Controllers;

use App\Models\Support\TicketAttachment;
use Illuminate\Support\Facades\Storage;

class SupportAttachmentController extends Controller
{
    /**
     * Serve a ticket attachment from the private disk after an authorisation check.
     * Only whitelisted image types are shown inline; everything else is forced to download.
     */
    public function show(TicketAttachment $attachment)
    {
        $user = auth()->user();
        $ticket = $attachment->ticket;

        abort_unless($ticket && $user->can('view', $ticket), 404);

        if ($attachment->comment && $attachment->comment->is_internal) {
            abort_unless($user->can('viewInternal', $ticket), 404);
        }

        $disk = Storage::disk(config('support.attachments.disk'));
        abort_unless($disk->exists($attachment->path), 404);

        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'Content-Security-Policy' => "default-src 'none'; sandbox",
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ];

        $path = $disk->path($attachment->path);

        if ($attachment->isInlineImage()) {
            return response()->file($path, $headers + ['Content-Type' => $attachment->mime_type]);
        }

        return response()->download($path, $attachment->original_name, $headers);
    }
}
