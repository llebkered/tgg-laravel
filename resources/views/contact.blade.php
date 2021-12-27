@extends('layouts.app')

@section('content')

<section class="section content">

    <div class="container is-max-widescreen">
        <div class="columns">
            <div class="column">
                <h1 class="title is-1">{{ $page->title}}</h1>
                <p>Current time in Melbourne: {{ now("Australia/Melbourne")->format('h:i A T') }} </p>
                {!! $page->body !!}
            </div>
            <div class="column  has-background-light">
                @if(session('message'))
                <div class='alert alert-success'>
                    {{ session('message') }}
                </div>
                @endif

                <form action="" method="POST">
                    @csrf
                    @honeypot

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input is-medium" type="text" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input is-medium" type="text" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Subject</label>
                        <div class="control">
                            <input class="input is-medium" type="text" name="subject" value="{{ old('subject') }}">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Phone</label>
                        <div class="control">
                            <input class="input is-medium" type="text" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Message</label>
                        <div class="control">
                            <textarea class="textarea is-medium" name="message">{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LcN_sESAAAAAOWD5PSJ1y_QePb-delgio5edjnF"></div>
                    <br />

                    <div class="control">
                        <button type="submit" class="button is-link is-fullwidth has-text-weight-medium is-medium">Send
                            Message</button>
                    </div>
                </form>
            </div>
        </div>

</section>

@endsection


@section('header_extras')
<!-- recaptcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
