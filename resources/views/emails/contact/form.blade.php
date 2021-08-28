@component('mail::message')


# Contact Form Message

You have got an email from : {{ $data['name'] }}

### User details:

Name: {{ $data['name'] }} <br>
Email: {{ $data['email'] }} <br>
Phone: {{ $data['phone'] }} <br>
Subject: {{ $data['subject'] }} <br><br>

---
## Message: 

{{ $data['message'] }} 


@endcomponent

