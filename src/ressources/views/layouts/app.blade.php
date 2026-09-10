@php
// Check user Admin Guard
auth()->user()->isSuperAdmin()
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ __('IpsumAdmin::layout.Administration') }} - {{ config('settings.nom_site', 'Ipsum') }}</title>
    @if(config('ipsum.admin.favicon'))
        <link rel="shortcut icon" href="{{ config('ipsum.admin.favicon') }}" type="image/x-icon" />
    @endif
    <!-- Optional CDN -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/solid.min.css" rel="stylesheet">

    <link rel="stylesheet" href="@asset_versioned('ipsum/admin/dist/main.css')">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');


        :root {
            /* Dynamic Palette */
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-soft: #eef2ff;

            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --bg-sidebar: #0f172a;

            --text-main: #334155;
            --text-muted: #64748b;
            --text-heading: #0f172a;

            --border-color: #e2e8f0;
            --radius: 8px;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07);
        }

        /* --- THÈME DE DÉFAUT (Indigo / Modern SaaS) --- */
        :root, [data-theme="light"] {
            --primary: #2563eb!important;
            --primary-hover: #1d4ed8!important;
            --primary-soft: #eef2ff!important;
            --bg-main: #f8fafc!important;
            --bg-card: #ffffff!important;
            --bg-sidebar: #0f172a!important;
            --sidebar-hover: #272e3f!important;
            --sidebar-text: #94a3b8!important;
            --sidebar-title: #64748b!important;
            --text-main: #334155!important;
            --text-muted: #64748b!important;
            --text-heading: #0f172a!important;
            --border-color: #e2e8f0!important;
        }

        /* --- THÈME DARK MODE --- */
        [data-theme="dark"] {
            --primary: #6366f1!important;
            --primary-hover: #4f46e5!important;
            --primary-soft: rgba(99, 102, 241, 0.15)!important;
            --bg-main: #090d16!important;
            --bg-card: #121827!important;
            --bg-sidebar: #0b0f19!important;
            --sidebar-hover: #1e293b!important;
            --sidebar-text: #94a3b8!important;
            --sidebar-title: #475569!important;
            --text-main: #cbd5e1!important;
            --text-muted: #64748b!important;
            --text-heading: #f8fafc!important;
            --border-color: #1e293b!important;
        }


        /* --- Base & Typography --- */
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .main-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        /* --- Ipsum Layout System (.l-global) --- */
        /*.l-global {
            display: grid;
            min-height: 100vh;
            grid-template-columns: 250px 1fr;
            grid-template-rows: 60px 1fr auto;
            grid-template-areas:
    "brand header-a header-b"
    "menu main main"
    "menu footer-a footer-b";
        }*/

        .brand {
            grid-area: brand;
            background-color: var(--bg-sidebar);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hamburger {
            background-color: var(--bg-sidebar);
            color: #fff;
        }

        .hamburger i{
             line-height: inherit;
        }

        .brand a {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
        }

        .l-global-header-a, .l-global-header-b {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
        }

        .main {
            grid-area: main;
            padding: 2rem;
            background-color: var(--bg-main);
        }

        /*.l-global-footer-a, .l-global-footer-b {
            padding: 1rem 2rem;
            background: var(--bg-card);
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.8rem;
        }*/

        /* --- Boxes / Cards (.box) --- */
        .box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .box-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-heading);
            margin: 0;
        }

        .box-body {
            padding: 1.5rem;
        }

        /* --- Tables Modernisation --- */
        .table-wrapper {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: #f1f5f9;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table-hover tbody tr:hover td {
            background-color: var(--primary-soft);
        }

        /* --- Buttons System --- */
        .btn-toolbar {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 6px;
            border: 1px solid transparent;
            transition: all 0.15s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }
        .btn-primary:hover { background: var(--primary-hover); color: #fff; }

        .btn-outline-secondary {
            background: #fff;
            border-color: var(--border-color);
            color: var(--text-main);
        }
        .btn-outline-secondary:hover {
            background: #f1f5f9;
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-danger {
            background: var(--bg-main);
            border-color: #fca5a5;
            color: #dc2626;
        }
        .btn-outline-danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* --- Badges (.badge) --- */
        .badge {
            display: inline-flex;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
        }

        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-danger  { background-color: #fee2e2; color: #991b1b; }

        /* --- Aire Form Inputs & Grid (.form-row, .form-group) --- */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -0.75rem;
            margin-left: -0.75rem;
        }

        .form-group {
            padding-right: 0.75rem;
            padding-left: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .col-md-6 { flex: 0 0 50%; max-width: 50%; }

        label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-heading);
            margin-bottom: 0.375rem;
        }

        input[type="text"], input[type="email"], input[type="password"], select, textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background-color: #fff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        /* --- Navigation Sidebar (.menu) --- */
        nav.menu {
            grid-area: menu;
            background-color: var(--bg-sidebar);
            padding: 1.25rem 0.75rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* Titles / Categories */
        .menu-title {
            padding: 0 0.75rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--sidebar-title);
            margin-bottom: 0.5rem;
        }

        /* Lists */
        .menu-section,
        .menu-submenu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        /* Base Links */
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 0.75rem;
            color: var(--sidebar-text);
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            cursor: pointer;
            padding-left: 0px!important;
        }

        .menu-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .menu-link.active {
            color: #ffffff;
            background-color: var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .menu-link.active, .menu-link:hover, .menu-link[aria-expanded="true"] {
            color: #fff;
            background-color: var(--sidebar-hover);
        }

        .menu-link[aria-expanded="true"] {
            border-right: 3px solid #2563eb;
        }
        .menu-submenu {
            border-right: 3px solid #2563eb;
        }

        /* Icons & Chevron Styling */
        .menu-link-icon {
            width: 1.25rem;
            margin-right: 0.75rem;
            text-align: center;
            font-size: 0.95rem;
            color: var(--sidebar-text);
            margin: 0!important;
        }

        .menu-link-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-link-right {
            font-size: 0.75rem;
            transition: transform 0.2s ease;
            color: #64748b;
        }

        .menu-link[aria-expanded="true"] .menu-link-right {
            transform: rotate(180deg);
            color: #ffffff;
        }

        /* Submenus Indentation & Accordion */
        .menu-submenu {
            padding-left: 0.85rem;
            margin-top: 0.25rem;
        }

        .menu-submenu .menu-link {
            font-size: 0.825rem;
            padding: 0.45rem 0.75rem;
            color: #64748b;
        }

        .menu-submenu .menu-link:hover {
            color: #cbd5e1;
        }

        .menu-submenu .menu-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }

        .menu-submenu .menu-link-icon {
            font-size: 0.35rem; /* Réduction de la taille de la puce d'icône */
            margin-right: 0.65rem;
            opacity: 0.7;
        }

        /* Collapse Transition Logic */
        .menu-submenu.collapse:not(.show) {
            display: none;
        }

        .menu-submenu.collapse.show {
            display: flex;
        }

        /* Style du sélecteur de thème dans le header */
        .theme-select {
            background-color: var(--bg-main);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.35rem 0.65rem;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.15s ease;
        }

        .theme-select:hover, .theme-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-soft);
        }
    </style>
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

    <script>
        // Application immédiate du thème pour éviter l'effet de flash au chargement
        (function() {
            const savedTheme = localStorage.getItem('ipsum_theme') || 'indigo';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('ipsum_theme') || 'indigo';
            const switcher = document.getElementById('theme-switcher');

            if (switcher) {
                switcher.value = savedTheme;
            }
        });

        function switchTheme(themeName) {
            document.documentElement.setAttribute('data-theme', themeName);
            localStorage.setItem('ipsum_theme', themeName);
        }
    </script>

    </body>
</html>
