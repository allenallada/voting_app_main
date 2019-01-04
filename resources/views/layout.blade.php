<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Voting App</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/alertifyjs/alertify.js"></script>
        <link rel="stylesheet" type="text/css" href="/js/alertifyjs/css/alertify.min.css">
        <link rel="stylesheet" type="text/css" href="/js/alertifyjs/css/themes/default.min.css">
        <link rel="stylesheet" type="text/css" href="/js/alertifyjs/css/themes/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="/js/alertifyjs/css/themes/bootstrap.min.css">
        @stack('styles')
        @include('alertify::alertify')

    </head>
    <body>
        @yield('content')

    </body>

    
    @stack('scripts')
</html>
