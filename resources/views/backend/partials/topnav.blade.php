    <!-- START NAV -->
    <nav class="navbar is-white">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item brand-text" href="{{ route('backend.index') }}">
                    Bulma Admin
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

            </div>
        </div>
    </nav>
    <!-- END NAV -->
