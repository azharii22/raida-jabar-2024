<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <!-- <title> @yield('title') | Skote - Responsive Bootstrap 4 Admin Dashboard</title> -->
    <title>Login | {{ config('settings.main.1_app_name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Raimuna Daerah Jawa Barat XIV Tahun 2024" name="description" />
    <meta content="{{ config('settings.main.1_app_name') }}" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo-raida.png')}}">
    @include('layouts.head-css')
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>