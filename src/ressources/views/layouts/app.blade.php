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
    
    <link rel="stylesheet" href="{{ asset('ipsum/admin/dist/main.css') }}">
</head>
<body>
    <div class="l-global">

        <div class="brand">
            <a href="{{ route('admin.dashboard') }}"> {{ __('IpsumAdmin::layout.Administration') }}</a>
        </div>

        <button id="hamburger" class="hamburger" type="button">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times"></i>
        </button>
       
        @include('IpsumAdmin::layouts._menu')

        <nav class="header l-global-header-a">
            
        </nav>
        <nav class="header l-global-header-b">
            <ul class="nav">
                <li>
                    <a class="nav-link" href="{{ url('/') }}">{{ __('IpsumAdmin::layout.Aller sur le site') }}</a>
                </li>
                @guest
                <li>
                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('IpsumAdmin::layout.Connexion') }}</a>
                </li>
                @else
                <li>
                    <div class="nav-link"><a href="{{ route('admin.logout') }}">{{ __('IpsumAdmin::layout.Déconnexion') }}</a> (<a href="{{ route('adminUser.edit', auth()->user()->id) }}">{{ auth()->user()->name }}</a>)</div>
                </li>
                @endguest
            </ul>
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

    <script src="{{ asset('ipsum/admin/dist/main.js') }}"></script>

    </body>
</html>
