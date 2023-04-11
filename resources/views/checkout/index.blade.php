@extends('layouts.app')

{{-- @section('header_extras')
<link href="{{ asset('/vendor/fancyapps/fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/fancyapps/carousel.css') }}" rel="stylesheet">
@endsection --}}

@section('content')

<div class="container  is-max-widescreen mt-6">
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li class="is-active"><a href="#">Contact</a></li>
            <li><a href="#">Delivery</a></li>
            <li><a href="#">Payment</a></li>
            <li><a href="#">Complete</a></li>
        </ul>
    </nav>
</div>

<section class="section content">
    <div class="container  is-max-widescreen">
        <h1>{{ $page['title']}}</h1>
        {{-- <h1>{{ $page['title']}}</h1>
        {!! $page['body'] !!} --}}

        @if (Cart::instance('cart')->count() > 0)
        <div class="columns is-multiline">
            <div class="column  register">
                <div class="columns">
                    <div class="column is-4">
                        <h2>Contact Details</h2>
                        <form action="" method="POST">
                            {{ csrf_field() }}
                            <div class="field">
                                <label for="name" class="label">Name</label>
                                <div class="control">
                                    <input name="name" class="input is-medium" type="text" placeholder="Firstname Lastname"
                                        value="{{ old('name')}}">
                                </div>
                                @error('name')
                                <div class="message is-danger">
                                    <div class="message-body">{{ $errors->first('name') }}</div>
                                </div>
                                @enderror

                            </div>
                            <div class="field">
                                <label for="email" class="label">Email</label>
                                <div class="control">
                                    <input name="email" class="input is-medium" type="email" placeholder="email@example.com"
                                        value="{{ old('email')}}">
                                </div>
                                @error('email')
                                <div class="message is-danger">
                                    <div class="message-body">{{ $errors->first('email') }}</div>
                                </div>
                                @enderror
                            </div>
                            <div class="field">
                                <label for="phone" class="label">Phone</label>
                                <div class="control">
                                    <input name="phone" class="input is-medium" type="text" placeholder="eg 03 7010 1234 or 0491 570 006"
                                        value="{{ old('phone')}}">
                                </div>
                                <p class="help">Note:  This should be Australian formatted landline (including area code) or mobile number.</p>
                                @error('phone')
                                <div class="message is-danger">
                                    <div class="message-body">{{ $errors->first('phone') }}</div>
                                </div>
                                @enderror
                            </div>
                            <input type="hidden" name="user_id" value="">
                            <button class="button is-block is-primary is-fullwidth is-medium">Submit</button>
                        </form>
                    </div>
                    <div class="column is-offset-1 is-7">
                        @include('partials.carousel')
                    </div>
                </div>
            </div>

        </div>

        @else
        <!-- Cart Empty -->

        @include('partials.cart-empty')

        @endif

    </div>
</section>

@endsection

{{-- @section('footer_extras')
<script src="{{ asset('vendor/fancyapps/fancybox.umd.js') }}" rel="stylesheet"></script>
<script src="{{ asset('vendor/fancyapps/carousel.umd.js') }}" rel="stylesheet"></script>
<script>
    const myCarousel = new Carousel(document.querySelector("#myCarousel"), {  // Your options go here
    });
</script>
@endsection --}}
