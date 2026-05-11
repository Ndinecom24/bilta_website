<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterSubscriptionMail;
use App\Models\Bilta\ContactUs;
use App\Models\NewsletterSubscriber;
use App\Services\SpamFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            Log::warning('Newsletter honeypot triggered', ['ip' => $request->ip()]);
            return back()->with('newsletter_success', 'Thank you for subscribing to our newsletter.');
        }

        // Timing trap — reject if submitted in under 3 seconds
        $loadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($loadedAt > 0 && (now()->timestamp - $loadedAt) < 3) {
            Log::warning('Newsletter timing trap triggered', ['ip' => $request->ip()]);
            return back()->with('newsletter_success', 'Thank you for subscribing to our newsletter.');
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($validated['email']));

        // Check email against spam blacklists
        $spamFilter = app(SpamFilterService::class);
        if ($spamFilter->isSpam($email, '', '')) {
            Log::warning('Newsletter spam email blocked', ['email' => $email, 'ip' => $request->ip()]);
            return back()->with('newsletter_success', 'Thank you for subscribing to our newsletter.');
        }

        $subscriber = NewsletterSubscriber::firstOrCreate([
            'email' => $email,
        ]);

        if ($subscriber->wasRecentlyCreated) {
            $recipient = ContactUs::query()->value('email') ?: 'infor@bilta.org';

            try {
                $mailer = app()->environment('local') ? 'log' : config('mail.default');
                Mail::mailer($mailer)->to($recipient)->send(new NewsletterSubscriptionMail($subscriber));
            } catch (\Throwable $exception) {
                Log::error('Error sending newsletter subscription email: ' . $exception->getMessage());
            }

            return back()->with('newsletter_success', 'Thank you for subscribing to our newsletter.');
        }

        return back()->with('newsletter_success', 'You are already subscribed to our newsletter.');
    }
}
