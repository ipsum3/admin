@php
// Check user Admin Guard
auth()->user()->isSuperAdmin()
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ __('IpsumAdmin::layout.Administration') }} - {{ config('settings.nom_site', 'Ipsum') }}</title>

    <!-- Optional CDN -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/solid.min.css" rel="stylesheet">

    <link rel="stylesheet" href="@asset_versioned('ipsum/admin/dist/main.css')">
</head>
<body>
    <div class="l-global">

        <div class="brand">
            <a href="{{ route('admin.dashboard') }}"> {{ config('ipsum.admin.nom', __('IpsumAdmin::layout.Administration')) }}</a>
        </div>

        <button id="hamburger" class="hamburger" type="button">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times"></i>
        </button>

        @include('IpsumAdmin::layouts._menu')

        <nav class="header l-global-header-a">
            <a id="sidebar-button" class="nav-link sidebar-toggle"><i class="fas fa-angle-left"></i></a>
        </nav>
        <nav class="header l-global-header-b">
            @include('IpsumAdmin::layouts._nav_header')
        </nav>

        <main role="main" class="main">

            @include('IpsumAdmin::partials.alert')

            @yield('content')

        </main>
        <div class="footer l-global-footer-a">

        </div>
        <div class="footer l-global-footer-b">
            <a href="https://github.com/ipsum3">Ipsum</a>
        </div>
    </div>

    <script src="@asset_versioned('ipsum/admin/dist/main.js')"></script>

    </body>
</html>
