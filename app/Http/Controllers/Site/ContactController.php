<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Bilta\Testimonial;
use App\Models\ContactMessage;
use App\Services\SpamFilterService;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class ContactController extends Controller
{

    protected $spamFilter;

    public function __construct(SpamFilterService $spamFilter)
    {
        $this->spamFilter = $spamFilter;
    }
    public function store(Request $request)
    {

        // Honeypot check
        if ($request->filled('website')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Bot submission blocked'], 400);
            }

            return back()->with('contact_error', 'Submission blocked. Please try again.');
        }

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Prepare additional data
        $validated['status_id'] = 1;
        $validated['created_by'] = 0;
        $validated['recipient'] = "infor@bilta.org";
        $hasSpamColumn = Schema::hasColumn('contact_messages', 'spam');

        $isSpam = $this->spamFilter->isSpam($validated['email'], $validated['subject'], $validated['message']);

        try {
            // Save the message to the database
            if ($hasSpamColumn) {
                $validated['spam'] = $isSpam ? 1 : 0;
            }

            $contactMessage = ContactMessage::updateOrCreate(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'subject' => $validated['subject'],
                    'message' => $validated['message'],
                ],
                $validated
            );

            if (! $isSpam) {
                // Send the email (use log mailer locally to avoid SMTP blocking during development)
                $mailer = app()->environment('local') ? 'log' : config('mail.default');
                Mail::mailer($mailer)->to('infor@bilta.org')->send(new \App\Mail\ContactMessageMail($contactMessage));
            }

            // Return success response
            $successMessage = $isSpam
                ? 'Your message has been saved.'
                : 'Your message has been sent successfully.';

            if ($request->expectsJson()) {
                return response()->json(['success' => $successMessage], 200);
            }

            return back()->with('contact_success', $successMessage);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error sending contact message: ' . $e->getMessage());

            // Return error response with the exception message
            if ($request->expectsJson()) {
                return response()->json(['error' => 'There was an issue sending your message. Please try again later.'], 500);
            }

            return back()->with('contact_error', 'There was an issue sending your message. Please try again later.');
        }
    }


    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'testimonial' => 'required|string|max:1000',
        ]);

        try{

            Testimonial::updateOrCreate(

                [
                    'name' => $validated['name'],
                    'title' => $validated['title'],
                    'testimonial' => $validated['testimonial'],
                ],
                [
                    'name' => $validated['name'],
                    'title' => $validated['title'],
                    'testimonial' => $validated['testimonial'],
                    'status_id' => 0,
                    'created_by' => 0,
                ]
            );
            return response()->json(['message' => 'Thank you for your testimonial! Has been sent to admin.']);

        }catch(Exception $exception){
            Log::error('Error saving testimonial: ' . $exception->getMessage());
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
      
    }
}
