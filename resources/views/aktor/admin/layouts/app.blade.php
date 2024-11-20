<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

    @yield('css')

    <script src="{{ asset('assets/js/config.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css" id="app-style">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}" type="text/css">
</head>

<body>
    <div class="wrapper">
        @include('aktor.admin.layouts.header')
        @include('aktor.admin.layouts.sidebar')

        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>

            @include('aktor.admin.layouts.footer')
        </div>
    </div>

    @yield('modal')
    @include('sweetalert::alert')

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    @yield('js')

    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    @yield('script')
</body>
</html>
