<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') | {{ config('settings.main.1_app_name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ config('settings.main.1_app_name') }}" name="author">
    <meta content="{{ config('settings.main.2_app_description') }}" name="description">

    {{-- <!-- Favicon --> --}}
    <link href="{{ config('settings.main.3_app_logo') }}" rel="icon">

    @include('viewUser.layouts.head-css')
    @yield('css')
</head>

<body>
    <div class="container-xxl bg-white p-0">
        {{-- <!-- Spinner Start --> --}}
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        {{-- <!-- Spinner End --> --}}
        {{-- <!-- Navbar & Hero Start --> --}}
        <div class="container-xxl position-relative p-0">
            <nav class="bg-header navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img src="assets/viewUser/img/raida/cakaran-1.1.png" alt="">
                    <img src="{{ URL::asset('assets/viewUser/img/raida/Raida Putih.png') }}" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('viewUser') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser') ? 'active' : '' }}">Beranda</a>
                        <a href="{{ route('viewUser.tentang') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser.tentang') ? 'active' : '' }}">Tentang</a>
                        <a href="{{ route('viewUser.media-unduh') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser.media-unduh') ? 'active' : '' }}">Media
                            Unduh</a>
                        <a href="{{ route('viewUser.artikel') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser.artikel') ? 'active' : '' }}">Artikel</a>
                        <a href="{{ route('viewUser.kegiatan') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser.kegiatan') ? 'active' : '' }}">Kegiatan</a>
                        <a href="{{ route('viewUser.jadwalKegiatan') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser.jadwalKegiatan') ? 'active' : '' }}">Jadwal
                            Kegiatan</a>
                        <a href="{{ route('viewUser.dokumentasi') }}"
                            class="nav-item nav-link {{ request()->routeIs('viewUser.dokumentasi') ? 'active' : '' }}">Dokumentasi</a>
                    </div>
                    <a href="/login" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Login</a>
                </div>
            </nav>
            <div class="bg-header p-5"></div>
        </div>
        {{-- <!-- Navbar & Hero End --> --}}

        @yield('navbar')
        @yield('content')
        @include('viewUser.layouts.footer')


        {{-- <!-- Back to Top --> --}}
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i
                class="bi bi-arrow-up"></i></a>
    </div>

    @include('viewUser.layouts.vendor-script')
    @yield('script')
</body>

</html>
