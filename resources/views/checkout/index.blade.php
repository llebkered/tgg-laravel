@extends('layouts.app')

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

        @if (Cart::count() > 0)
        <div class="columns is-multiline">
            <div class="column is-8 is-offset-2 register">
                <div class="columns">
                    <div class="column left">
                        <h2>Contact Details</h2>
                        <form action="" method="POST">
                            {{ csrf_field() }}
                            <div class="field">
                                <label for="name" class="label">Name</label>
                                <div class="control">
                                    <input name="name" class="input is-medium" type="text" placeholder="Name"
                                        value="{{ old('name')}}">
                                </div>
                            </div>
                            <div class="field">
                                <label for="email" class="label">Email</label>
                                <div class="control">
                                    <input name="email" class="input is-medium" type="email" placeholder="Email"
                                        value="{{ old('email')}}">
                                </div>
                            </div>
                            <div class="field">
                                <label for="phone" class="label">Phone</label>
                                <div class="control">
                                    <input name="phone" class="input is-medium" type="text" placeholder="Phone"
                                        value="{{ old('phone')}}">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="">
                            <button class="button is-block is-primary is-fullwidth is-medium">Submit</button>
                        </form>
                    </div>
                    <div class="column right">
                        @if ($page->image)
                        <figure class="image">
                            <img src="{{ asset('storage/app/public/' . $page->image)}}" alt="Image: {{ $page->title }}">
                        </figure>
                        @endif
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