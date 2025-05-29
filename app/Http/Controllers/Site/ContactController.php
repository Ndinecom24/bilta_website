<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Bilta\Testimonial;
use App\Models\ContactMessage;
use App\Services\SpamFilterService;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

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
            return response()->json(['error' => 'Bot submission blocked'], 400);
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

         // Spam filter check
         if ($this->spamFilter->isSpam($validated['email'], $validated['subject'], $validated['message'])) {   // Save the message to the database
            $validated['spam'] = 1 ;
            $contactMessage = ContactMessage::updateOrCreate($validated, $validated);
            return response()->json(['success' => 'Your message has been saved.'], 200 );
        }

        try {
            // Save the message to the database
            $validated['spam'] = 0 ;
            $contactMessage = ContactMessage::updateOrCreate($validated, $validated);

            // Send the email (ensure the ContactMessageMail mailable is set up)
            Mail::to('infor@bilta.org')->send(new \App\Mail\ContactMessageMail($contactMessage));

            // Return success response
            return response()->json(['success' => 'Your message has been sent successfully.'], 200 );

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error sending contact message: ' . $e->getMessage());

            // Return error response with the exception message
            return response()->json(['error' => 'There was an issue sending your message. Please try again later.' . $e->getMessage()], 500);
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
            return response()->json(['message' => 'Error : '.$exception->getMessage() ]);
        }
      
    }
}
