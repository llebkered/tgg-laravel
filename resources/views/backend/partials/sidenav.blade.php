<aside class="menu">
    <p class="menu-label mt-6">
        Menu
    </p>
    <ul class="menu-list">
        <li><a href="{{ route('home')}}">Go to home page</a></li>
    </ul>
    <p class="menu-label">
        Admin
    </p>
    <ul class="menu-list">
        <li><a href="{{ route('backend.pages') }}">Pages</a></li>
        <li><a href="{{ route('backend.plants') }}"> Plants </a></li>
        <a href="{{ route('backend.products') }}">Products</a></li>
        <li><a href="{{ route('backend.orders') }}">Orders</a></li>
        <li><a href="{{ route('backend.users') }}">Users</a></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="navbar-item">
        {{ csrf_field() }}
        <button class="button is-danger is-inverted">Log Out</button>
    </form>
</aside>
