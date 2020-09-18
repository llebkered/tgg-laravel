<footer class="footer">
    <div class="containeris-fluid">
        <div class="columns">
            <div class="column">
                <h3>{{ config('app.name', 'TGG') }}</h3>
                <p>ABN 61 173 928 602</p>
                <p>{{ now("Australia/Melbourne")->format('h:i A T') }}</p>
            </div>
            <div class="column">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('ferns') }}">Ferns</a></li>
                    <li><a href="{{ route('paulownia') }}">Paulownia</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('products') }}">Products</a></li>
                </ul>
            </div>
            <div class="column is-half">
                <p> TGG value your feedback. Please contact us with any comments or queries.
                    All contents of this site, unless otherwise noted, are ©{{ now()->year }} copyright Toad Gully
                    Growers.</p>
            </div>
        </div>
        <div class="web-credit">Site by <a href="https://lucid.com.au">Lucid Web Design</a></div>
    </div>
    <script src="{{ asset('public/js/menu.js') }}" defer></script>
    @yield('footer_extras')
</footer>
