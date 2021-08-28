<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '=', 'contact-us')->first();

        return view('contact', ['page' => $page]);
    }

    // Store Contact Form data
    public function store(Request $request)
    {

        // Form validation
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => '', //'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'subject' => 'required',
            'message' => 'required'
        ]);


        //  Store data in database
        Contact::create($data);

        //  Send mail to admin
        // Mail::send('emails.contact.form', array(
        //         'name' => $request->get('name'),
        //         'email' => $request->get('email'),
        //         'phone' => $request->get('phone'),
        //         'subject' => $request->get('subject'),
        //         'user_query' => $request->get('message'),
        //     ), function ($message) use ($request) {
        //         $message->from($request->email);
        //         $message->to('sales@toadgully.com.au', 'Toadgully Growers')->subject($request->get('subject'));
        //     });

        Mail::to('sales@toadgully.com.au')
            // ->cc('sales2@toadgully.com.au')
            // ->cc('sales3@toadgully.com.au')
            ->send(new ContactMail($data));

        //
        return back()->with('success_message', 'We have received your message and would like to thank you for writing to us.');
    }
}
