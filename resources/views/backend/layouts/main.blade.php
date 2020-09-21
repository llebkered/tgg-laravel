<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Free Bulma template</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <!-- Bulma Version 0.9.0-->
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.0/css/bulma.min.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('header_extras')
</head>

<body>
    @include('backend.partials.topnav')
    <div class="container">
        <div class="columns">
            <div class="column is-3">
                @include('backend.partials.sidenav')
            </div>
            <div class="column is-9">
                <div class="container">
                    @include('partials.flash-message')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script async type="text/javascript" src="{{ asset('js/bulma.js') }}"></script>
    @yield('footer_extras')
</body>

</html>
