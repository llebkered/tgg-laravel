@extends('backend.layouts.main')

@section('content')

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-8 is-offset-2">
                <h3 class="title has-text-black">Forgot Password</h3>
                @include('auth.partials.messages')
                <hr class="login-hr">
                <p class="subtitle has-text-black">Enter your email address and we will email you a link to choose a new password.</p>
                <div class="box">
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="email" type="email" placeholder="Your Email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                        </div>
                        <button class="button is-block is-primary is-large is-fullwidth">Email Password Reset Link</button>
                    </form>
                </div>
                <p class="has-text-grey">
                    <a href="{{ route('login') }}">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
