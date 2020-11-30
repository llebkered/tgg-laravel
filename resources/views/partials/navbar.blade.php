<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
            data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="{{ route('home') }}">
                Home
            </a>

            <a class="navbar-item" href="{{ route('ferns') }}">
                Ferns
            </a>

            <a class="navbar-item" href="{{ route('paulownia') }}">
                Paulownia
            </a>

            <a class="navbar-item" href="{{ route('contact') }}">
                Contact Us
            </a>

            {{-- <a class="navbar-item" href="{{ route('products') }}">
                Products
            </a> --}}

        </div>

        <div class="navbar-end">
            <div class="navbar-item">

                <a class="navbar-item" href="{{ route('cart.index') }}">
                    @if (Cart::count() > 0)
                    <span class="tag is-info is-rounded is-size-6">{{ Cart::count() }}</span>
                    @endif
                    <span class="mx-3">
                        <img class="mdi-white" src="{{ asset('images/cart-white.svg') }}" alt="Cart">
                    </span>
                    Cart
                </a>

                @auth
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/admin" class="navbar-item">Voyager Admin</a>
                        <a href="{{ route('backend.index') }}" class="navbar-item">TGG Dashboard</a>
                        <hr class="navbar-divider">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="navbar-item">
                            {{ csrf_field() }}
                            <button class="button is-danger is-inverted">Log Out</button>
                        </form>
                    </div>
                </div>
                @endauth


            </div>
        </div>
    </div>
</nav>
