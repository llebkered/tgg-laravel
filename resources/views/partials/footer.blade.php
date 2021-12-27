<footer class="footer">
    <div class="container is-max-widescreen">
        <div class="columns">
            <div class="column">
                <h3>{{ config('app.name', 'TGG') }}</h3>
                <p>ABN {{ config('tgg.abn', '61 173 928 602') }}
                <p>{{ now("Australia/Melbourne")->format('h:i A T') }}</p>
            </div>
            <div class="column">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('ferns') }}">Ferns</a></li>
                    <li><a href="{{ route('paulownia') }}">Paulownia</a></li>
                    <li><a href="{{ route('products') }}">Products</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
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
    <script src="{{ asset('js/menu.js') }}" defer></script>
    @yield('footer_extras')
    {{-- <script src="https://cdn.jsdelivr.net/npm/luxon@2.2.0/build/global/luxon.min.js"></script>
    <script>
        import { DateTime } from "luxon";
        var datetime = DateTime.now().setZone('Australia/Melbourne').toFormat('yyyy-MM-dd HH:mm:ss');
        // document.getElementById("datetime").innerHTML = datetime;
        // console.log(datetime);
        console.log('hello');
    </script> --}}
</footer>
