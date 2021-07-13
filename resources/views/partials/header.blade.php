<header class="header">
    <div class="container is-max-widescreen header__container">
        <div class="header__logo"><a href="{{ route('home')}}">
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name', 'Laravel') }}"></a>
        </div>

        <div class="header__title">
            <img src="{{ asset('images/toad-gully-growers.svg')}}" alt="{{ config('app.name', 'Laravel') }}"
                title="{{ config('app.name', 'Laravel') }}">
        </div>

    </div>
</header>