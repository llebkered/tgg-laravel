<!-- START NAV -->
<nav class="navbar">
    <div class="container is-fluid">
        <div class="navbar-brand">
            <a class="navbar-item brand-text" href="{{ route('backend.index') }}">
                TGG Admin
            </a>
            <div class="navbar-burger burger" data-target="navMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="navMenu" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="{{ route('backend.index') }}">
                    Dashboard
                </a>
                <a class="navbar-item" href="{{ route('backend.pages') }}">
                    Pages
                </a>
                <a class="navbar-item" href="{{ route('backend.plants') }}">
                    Plants
                </a>
                <a class="navbar-item" href="{{ route('backend.products') }}">
                    Products
                </a>
                <a class="navbar-item" href="{{ route('backend.orders') }}">
                    Orders
                </a>
                <a class="navbar-item" href="{{ route('backend.users') }}">
                    Users
                </a>
            </div>
            @auth
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="navbar-dropdown">
                            <hr class="navbar-divider">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="navbar-item">
                                {{ csrf_field() }}
                                <button class="button is-danger is-inverted">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
        </div>
    </div>
</nav>
<!-- END NAV -->
