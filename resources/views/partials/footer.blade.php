<footer class="footer">
    <div class="container is-max-widescreen">
        <div class="columns">
            <div class="column">
                <h3>{{ config('app.name', 'TGG') }}</h3>
                <p>ABN {{ config('tgg.abn', '61 173 928 602') }}
                <p id="melbourne-clock">{{ now("Australia/Melbourne")->format('h:i A T') }}</p>
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
    <script>
        (function () {
            var clock = document.getElementById('melbourne-clock');
            if (!clock || !window.Intl) return;

            // Australia/Melbourne switches between AEST and AEDT automatically
            var formatter = new Intl.DateTimeFormat('en-AU', {
                timeZone: 'Australia/Melbourne',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true,
                timeZoneName: 'short'
            });

            function tick() {
                var parts = {};
                formatter.formatToParts(new Date()).forEach(function (p) { parts[p.type] = p.value; });
                clock.textContent = parts.hour + ':' + parts.minute + ':' + parts.second + ' '
                    + (parts.dayPeriod || '').toUpperCase() + ' ' + parts.timeZoneName;
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>
</footer>
