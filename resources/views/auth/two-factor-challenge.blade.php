@extends('backend.layouts.main')

@section('content')

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-8 is-offset-2">
                <h3 class="title has-text-black">Two-Factor Authentication</h3>
                @include('auth.partials.messages')
                <hr class="login-hr">
                <p class="subtitle has-text-black">Enter the code from your authenticator app, or one of your recovery codes.</p>
                <div class="box">
                    <form action="{{ route('two-factor.login.store') }}" method="POST">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="code" type="text" inputmode="numeric"
                                    placeholder="Authentication Code" autofocus autocomplete="one-time-code">
                            </div>
                        </div>

                        <p class="has-text-grey mb-3">or</p>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="recovery_code" type="text"
                                    placeholder="Recovery Code" autocomplete="one-time-code">
                            </div>
                        </div>
                        <button class="button is-block is-primary is-large is-fullwidth">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
