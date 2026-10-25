<aside class="menu side-menu">
    <div class="side-menu__header mb-4">
        <h1 class="is-size-5"><a href="{{ route('backend.index') }}" style="color: inherit">TGG Dashboard</a></h1>
        <p class="menu-user">
            <span class="material-icons">
                account_circle
            </span>
            @auth
            {{ Auth::user()->name }}
            @endauth
        </p>
    </div>
    <ul class="menu-list">
        <li><a href="{{ route('backend.pages.index') }}"><span class="material-icons">article</span> Pages</a></li>
        <li><a href="{{ route('backend.plants.index') }}"><span class="material-icons">local_florist</span>  Plants </a></li>
        <li><a href="{{ route('backend.products.index') }}"><span class="material-icons">nature</span> Products</a></li>
        <li><a href="{{ route('backend.orders.index') }}"><span class="material-icons">payments</span> Orders</a></li>
        <li><a href="{{ route('backend.users') }}"><span class="material-icons">supervised_user_circle</span> Users</a></li>
        <li><a href="{{ route('backend.guide') }}"><span class="material-icons">help_outline</span> Help</a></li>
        <li><a href="{{ route('backend.guide', 'developer') }}"><span class="material-icons">code</span> Developer Guide</a></li>
    </ul>
    <hr class="navbar-divider">
    <ul class="menu-list">
        <li><a href="{{ route('home')}}"><span class="material-icons">home</span> Home Page</a> </li>
    </ul>
    <hr class="navbar-divider">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-6">
        {{ csrf_field() }}
        <button class="button is-link is-outlined"><span class="material-icons">exit_to_app</span> Log Out</button>
    </form>
</aside>
