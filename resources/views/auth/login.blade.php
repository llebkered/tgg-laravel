@extends('backend.layouts.main')

@section('content')

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-8 is-offset-2">
                <h3 class="title has-text-black">Login</h3>
                @include('auth.partials.messages')
                <hr class="login-hr">
                <p class="subtitle has-text-black">Please login to proceed.</p>
                <div class="box">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="email" type="email" placeholder="Your Email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="password" type="password" placeholder="Your Password"
                                    required autocomplete="current-password">
                            </div>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="remember">
                                Remember me
                            </label>
                        </div>
                        <button class="button is-block is-primary is-large is-fullwidth">Login</button>
                    </form>
                </div>
                <p class="has-text-grey">
                    <a href="{{ route('password.request') }}">Forgot Password</a>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
