<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\SponsorInquiryMail;
use App\Models\Bilta\ContactUs;
use App\Models\SponsorInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SponsorInquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sponsor_name' => 'required|string|max:255',
            'sponsor_email' => 'required|email|max:255',
            'sponsor_message' => 'required|string|max:2000',
        ]);

        $inquiry = SponsorInquiry::create([
            'name' => trim($validated['sponsor_name']),
            'email' => strtolower(trim($validated['sponsor_email'])),
            'message' => trim($validated['sponsor_message']),
        ]);

        $recipient = ContactUs::query()->value('email') ?: 'info@bilta.org';

        try {
            $mailer = app()->environment('local') ? 'log' : config('mail.default');
            Mail::mailer($mailer)->to($recipient)->send(new SponsorInquiryMail($inquiry));
        } catch (\Throwable $exception) {
            Log::error('Error sending sponsor inquiry email: ' . $exception->getMessage());
        }

        return back()->with('sponsor_inquiry_success', 'Thank you. Your sponsorship inquiry has been received.');
    }
}
