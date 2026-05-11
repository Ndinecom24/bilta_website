<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\SponsorInquiryMail;
use App\Models\Bilta\ContactUs;
use App\Models\SponsorInquiry;
use App\Services\SpamFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SponsorInquiryController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            Log::warning('Sponsor inquiry honeypot triggered', ['ip' => $request->ip()]);
            return back()->with('sponsor_inquiry_success', 'Thank you. Your sponsorship inquiry has been received.');
        }

        // Timing trap — reject if submitted in under 3 seconds
        $loadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($loadedAt > 0 && (now()->timestamp - $loadedAt) < 3) {
            Log::warning('Sponsor inquiry timing trap triggered', ['ip' => $request->ip()]);
            return back()->with('sponsor_inquiry_success', 'Thank you. Your sponsorship inquiry has been received.');
        }

        $validated = $request->validate([
            'sponsor_name' => 'required|string|max:255',
            'sponsor_email' => 'required|email|max:255',
            'sponsor_message' => 'required|string|max:2000',
        ]);

        // Spam filter check
        $spamFilter = app(SpamFilterService::class);
        if ($spamFilter->isSpam($validated['sponsor_email'], '', $validated['sponsor_message'])) {
            Log::warning('Sponsor inquiry spam blocked', ['email' => $validated['sponsor_email'], 'ip' => $request->ip()]);
            return back()->with('sponsor_inquiry_success', 'Thank you. Your sponsorship inquiry has been received.');
        }

        $inquiry = SponsorInquiry::create([
            'name' => trim($validated['sponsor_name']),
            'email' => strtolower(trim($validated['sponsor_email'])),
            'message' => trim($validated['sponsor_message']),
        ]);

        $recipient = ContactUs::query()->value('email') ?: 'infor@bilta.org';

        try {
            $mailer = app()->environment('local') ? 'log' : config('mail.default');
            Mail::mailer($mailer)->to($recipient)->send(new SponsorInquiryMail($inquiry));
        } catch (\Throwable $exception) {
            Log::error('Error sending sponsor inquiry email: ' . $exception->getMessage());
        }

        return back()->with('sponsor_inquiry_success', 'Thank you. Your sponsorship inquiry has been received.');
    }
}
