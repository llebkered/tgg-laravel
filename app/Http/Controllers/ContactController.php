<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactFormRequest;
use App\Notifications\ContactFormMessage;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '=', 'contact-us')->firstOrFail();

        return view('contact', ['page' => $page]);
    }

    // Store Contact Form data
    public function store(ContactFormRequest $message, Contact $recipient)
    {
        $recipient->notify(new ContactFormMessage($message));

        // store the message in the database
        $recipient->name = $message->name;
        $recipient->email = $message->email;
        $recipient->subject = $message->subject;
        $recipient->phone = $message->phone;
        $recipient->message = $message->message;
        $recipient->save();
        return redirect()->back()->with('success_message', 'Thanks for your message! We will get back to you soon!');
    }
}
