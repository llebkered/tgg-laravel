@extends('backend.layouts.main')

@section('content')

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-8 is-offset-2">
                <h3 class="title has-text-black">Reset Password</h3>
                @include('auth.partials.messages')
                <hr class="login-hr">
                <p class="subtitle has-text-black">Choose a new password.</p>
                <div class="box">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="email" type="email" placeholder="Your Email"
                                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="password" type="password" placeholder="New Password"
                                    required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="password_confirmation" type="password"
                                    placeholder="Confirm New Password" required autocomplete="new-password">
                            </div>
                        </div>
                        <button class="button is-block is-primary is-large is-fullwidth">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
