<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') | {{ config('settings.main.1_app_name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ config('settings.main.1_app_name') }}" name="keywords">
    <meta content="{{ config('settings.main.2_app_description') }}" name="description">

    {{-- <!-- Favicon --> --}}
    <link href="{{ config('settings.main.3_app_logo') }}" rel="icon">

    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo-raida.png')}}">

    @include('viewUser.layouts.head-css')
    @yield('css')
</head>

<body>
    <div class="container-xxl bg-white p-0">
        {{-- <!-- Spinner Start --> --}}
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        {{-- <!-- Spinner End --> --}}


        @include('viewUser.layouts.navbar')
        @yield('content')
        @include('viewUser.layouts.footer')


        {{-- <!-- Back to Top --> --}}
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('viewUser.layouts.vendor-script')
    @yield('script')
</body>

</html>