<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@isset($page) {{ $page['title'] }} |@endisset {{ config('app.name', 'Laravel') }}</title>

    @include('partials.head-meta')

    {{-- <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.0/css/bulma.min.css" /> --}}
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=4" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="print">
    @yield('header_extras')
</head>

<body>
    <div id="app">

        @include('partials.header')

        @include('partials.navbar')

        @include('partials.flash-message')

        @if (isset($slot))
        {{ $slot }}
        @endif


        @yield('content')

        @include('partials.footer')
    </div>
</body>

</html>
