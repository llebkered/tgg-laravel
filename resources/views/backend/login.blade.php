@extends('backend.layouts.main')

@section('content')

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-8 is-offset-2">
                <h3 class="title has-text-black">Login</h3>
                @if (session('status'))
                <article class="message is-dark">
                    <div class="message-body">
                        {{ session('status') }}
                    </div>
                </article>
                @endif
                @if ($errors->any())
                <!-- errors -->
                <article class="message is-danger">
                    <div class="message-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </article>
                @endif
                <hr class="login-hr">
                <p class="subtitle has-text-black">Please login to proceed.</p>
                <div class="box">
                    <form action="{{ route('backend.login')}}" method="POST">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="email" type="email" placeholder="Your Email" autofocus="" value={{ old('email') }}>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="password" type="password" placeholder="Your Password">
                            </div>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="remember_me">
                                Remember me
                            </label>
                        </div>
                        <button class="button is-block is-primary is-large is-fullwidth">Login <i class="fa fa-sign-in"
                                aria-hidden="true"></i></button>
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
