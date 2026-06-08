<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Bilta\Testimonial;
use App\Models\Bilta\Testimonies;
use App\Models\ContactMessage;
use App\Services\SpamFilterService;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            Log::warning('Contact form honeypot triggered', ['ip' => $request->ip()]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Bot submission blocked'], 400);
            }
            return back()->with('contact_error', 'Submission blocked. Please try again.');
        }

        // Timing trap — reject if submitted in under 3 seconds
        $loadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($loadedAt > 0 && (now()->timestamp - $loadedAt) < 3) {
            Log::warning('Contact form timing trap triggered', ['ip' => $request->ip()]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Submission too fast. Please try again.'], 429);
            }
            return back()->with('contact_error', 'Please wait a moment before submitting.');
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

    public function storePublicTestimony(Request $request)
    {

        if ($request->filled('website')) {
            Log::warning('Public testimony honeypot triggered', ['ip' => $request->ip()]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Bot submission blocked'], 400);
            }
            return back()->withInput()->with('testimonial_error', 'Submission blocked. Please try again.');
        }

        $loadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($loadedAt > 0 && (now()->timestamp - $loadedAt) < 3) {
            Log::warning('Public testimony timing trap triggered', ['ip' => $request->ip()]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Submission too fast. Please try again.'], 429);
            }
            return back()->withInput()->with('testimonial_error', 'Please wait a moment before submitting.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'title' => 'nullable|string|max:255',
            'description' => 'required|string|min:20|max:5000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $isSpam = $this->spamFilter->isSpam(
            $validated['email'],
            $validated['title'] ?? 'testimony',
            $validated['description']
        );

        if ($isSpam) {
            Log::warning('Public testimony spam blocked', ['ip' => $request->ip(), 'email' => $validated['email']]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Submission blocked.'], 400);
            }
            return back()->withInput()->with('testimonial_error', 'We could not accept this submission. Please review your message and try again.');
        }

        $imagePath = null;
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('testimonies', 'public');
            }

            Testimonies::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'image' => $imagePath,
                'title' => $validated['title'] ?? 'Public Testimony Submission',
                'description' => $validated['description'],
                'status_id' => config('constants.status.pending', 3),
            ]);

            $message = 'Thank you for your testimony. It has been received and will be reviewed by BILTA admins before publishing.';
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 200);
            }

            return back()->with('testimonial_success', $message);
        } catch (\Exception $exception) {
            if (!empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            Log::error('Error saving public testimony: ' . $exception->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
            }

            return back()->withInput()->with('testimonial_error', 'An error occurred. Please try again later.');
        }
    }
}
