<aside class="menu side-menu">
    <div class="box">
        <p class="menu-user">
            {{ Auth::user()->name }}
        </p>
    </div>
    <ul class="menu-list">
        <li><a href="{{ route('backend.pages.index') }}">Pages</a></li>
        <li><a href="{{ route('backend.plants.index') }}"> Plants </a></li>
        <li><a href="{{ route('backend.products.index') }}">Products</a></li>
        <li><a href="{{ route('backend.orders.index') }}">Orders</a></li>
        <li><a href="{{ route('backend.users') }}">Users</a></li>
        <hr class="navbar-divider">
        <li> <a href="/admin">Voyager Admin</a></li>
        <hr class="navbar-divider">
        <li><a href="{{ route('home')}}">Go to home page</a></li>
    </ul>
    <hr class="navbar-divider">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="navbar-item">
        {{ csrf_field() }}
        <button class="button is-danger is-inverted">Log Out</button>
    </form>
</aside>
