@extends('layouts.app')

@section('content')

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-8 is-variable ">
                <div class="column is-two-thirds has-text-left">
                    <h1 class="title is-1">{{ $page->title}}</h1>
                    <p>Current time in Melbourne: {{ now("Australia/Melbourne")->format('h:i A T') }} </p>
                    {!! $page->body !!}
                </div>
                <div class="column is-one-third has-text-left has-background-light">
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
                        <div class="control">
                            <button type="submit"
                                class="button is-link is-fullwidth has-text-weight-medium is-medium">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

