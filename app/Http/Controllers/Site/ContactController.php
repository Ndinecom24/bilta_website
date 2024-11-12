<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
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
        $validated['recipient'] = "admin@bilta.org";

        try {
            // Save the message to the database
            $contactMessage = ContactMessage::updateOrCreate($validated, $validated);

            // Send the email (ensure the ContactMessageMail mailable is set up)
            Mail::to('admin@example.com')->send(new \App\Mail\ContactMessageMail($contactMessage));

            // Return success response
            return response()->json(['success' => 'Your message has been sent successfully.']);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error sending contact message: ' . $e->getMessage());

            // Return error response with the exception message
            return response()->json(['error' => 'There was an issue sending your message. Please try again later.'], 500);
        }
    }
}
