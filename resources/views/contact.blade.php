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

                <h3>Email</h3>
                <p><a href="mailto:sales@toadgully.com.au">sales@toadgully.com.au</a></p>

                {{-- @include('partials.contact-form') --}}
            </div>
        </div>

</section>

@endsection


@section('header_extras')
<!-- recaptcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
