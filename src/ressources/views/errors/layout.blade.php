<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>@yield('title')</title>

        <!-- Optional CDN -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/solid.min.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('ipsum/admin/dist/main.css') }}">
    </head>
    <body class="l-single">
        <div class="l-single-inner text-center">
            <h1 class="h1 ">Error <span>@yield('code')</span></h1>
            <p>@yield('message')</p>
            <a class="btn btn-lg btn-primary mt-4" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
    </body>
</html>
