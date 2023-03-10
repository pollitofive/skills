<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/mermaid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/multi.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/waves.min.css') }}">
        @yield('styles')
        @livewireStyles

        <style>
            .logo {
                color: white;
                font-size: 24px;
                font-weight: bold;
            }

            .invalid-feedback {
                display: block;
                width: 100%;
                margin-top: 0.25rem;
                font-size: .875em;
                color: #ed5e5e;
            }

        </style>
    </head>
    <body>
        <div id="layout-wrapper">
            @include('header')
            @include('menu')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('js/feather.min.js') }}"></script>
        <script src="{{ asset('js/multi.min.js') }}"></script>
        <script src="{{ asset('js/waves.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
        @livewireScripts
    </body>
</html>
