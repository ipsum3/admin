<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>@yield('title', __('IpsumAdmin::auth.Connexion administration'))</title>

        <!-- Optional CDN -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/solid.min.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('ipsum/admin/dist/main.css') }}">
    </head>
    <body class="l-single bg-gray">
        @yield('content')
    </body>

    <script src="{{ asset('ipsum/admin/dist/main.js') }}"></script>
</html>