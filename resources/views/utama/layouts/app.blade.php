<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('dist/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/material-design-iconic-font.min.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('dist/css/plugins.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('dist/css/responsive.css') }}" type="text/css">

    <script src="{{ asset('dist/vendor/modernizr-3.11.2.min.js') }}"></script>
</head>
<body>
    @include('utama.layouts.header')

    @yield('content')

    <script src="{{ asset('dist/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('dist/vendor/jquery-migrate-3.3.2.min.js') }}"></script>

    <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/plugins.js') }}"></script>

    <script src="{{ asset('dist/js/main.js') }}"></script>
</body>
</html>
