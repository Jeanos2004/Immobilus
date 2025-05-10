<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    // Handle contact form submission
    public function submitContactForm(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create new contact message record
        $contactMessage = new ContactMessage();
        $contactMessage->name = $request->name;
        $contactMessage->email = $request->email;
        $contactMessage->phone = $request->phone;
        $contactMessage->subject = $request->subject;
        $contactMessage->message = $request->message;
        $contactMessage->status = 'unread'; // Default status
        $contactMessage->save();

        // Send email notification (commented out for now as it requires email configuration)
        /*
        Mail::to('info@immobilus.com')->send(new ContactFormMail([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]));
        */

        // Return with success message
        $notification = array(
            'message' => 'Your message has been sent successfully. We will contact you soon.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
