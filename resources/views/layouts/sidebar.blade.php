<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->

            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4)
            <!-- Menu DKD / Admin Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Dashboards')</li>
                <li><a href="/admin" class="waves-effect"> <i class="bx bx-home-circle"></i> <span key="t-dashboards">@lang('translation.Dashboards')</span> </a> </li>
                <li class="menu-title" key="t-menu">Master Data</li>
                <li><a href="{{ route('admin-kategori.index') }}" key="t-tui-kategori"><i class="bx bx-file"></i><span key="t-kategori">Kategori</span></a></li>
                <li><a href="{{ route('admin-region.index') }}" key="t-tui-region"><i class="mdi mdi-flag"></i><span key="t-region">Region</span></a></li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-analyse"></i>
                        <span key="t-contacts">Master Administrasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin-data-berkas-kontingen.index') }}" key="t-user-grid">Data Berkas Kontingen</a></li>
                        <li><a href="{{ route('admin-data-peserta.index') }}" key="t-user-list">Data Peserta</a></li>
                        <li><a href="{{ route('admin-data-unsur-kontingen.index') }}" key="t-profile">Data Unsur Kontingen Cabang</a></li>
                        @if (auth()->user()->role_id == 4)
                        <li><a href="{{ route('admin-data-pembayaran.index') }}" key="t-pembayaran">Data Pembayaran</a></li>
                        @endif
                    </ul>
                </li>
                <li class="menu-title" key="t-pages">View User</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-analyse"></i>
                        <span key="t-contacts">Setting View User</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin-tentang.index') }}" key="t-user-grid">Tentang</a></li>
                        <li><a href="{{ route('admin-dokumen-penting.index') }}" key="t-tui-dokumenPenting"><span key="t-dokumenPenting">Dokumen Penting</span></a></li>
                        <li><a href="{{ route('admin-artikel.index') }}" class="waves-effect collapse">  <span key="t-dashboards">Artikel</span> </a> </li>
                        <li><a href="{{ route('admin-kegiatan.index') }}" key="t-tui-kegiatan"><span key="t-kegiatan">Kegiatan</span></a></li>
                        <li><a href="{{ route('admin-jadwal-kegiatan.index') }}" key="t-tui-jadwalKegiatan"><span key="t-jadwalKegiatan">Jadwal Kegiatan</span></a></li>
                        <li><a href="{{ route('admin-dokumentasi-kegiatan.index') }}" key="t-tui-dokumentasi"><span key="t-dokumentasi">Dokumentasi Kegiatan</span></a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-pages">@lang('translation.Pages')</li>
                <li> <a href="{{ route('admin-user.index') }}" class="waves-effect"> <i class="bx bx-user-circle"></i> <span key="t-dashboards">User Management</span> </a> </li>
                <li> <a href="{{ route('admin-settings.index') }}" class="waves-effect"> <i class="bx bx-cog"></i> <span key="t-dashboards">Settings</span> </a> </li>
            </ul>
            <!-- Menu DKD / Admin End -->

            @elseif (auth()->user()->role_id == 2)
            <!-- Menu DKR Star -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Dashboards')</li>
                <li><a href="/admin" class="waves-effect"> <i class="bx bx-home-circle"></i> <span key="t-dashboards">@lang('translation.Dashboards')</span> </a> </li>
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>
                <li><a href="{{ route('admin-data-berkas-kontingen.index') }}" key="t-user-grid"><i class="bx bx-file"></i>Data Berkas Kontingen</a></li>
                <li><a href="{{ route('admin-data-peserta.index') }}" key="t-user-list"><i class="bx bx-user"></i>Data Peserta</a></li>
                <li><a href="{{ route('admin-data-unsur-kontingen.index') }}" key="t-profile"><i class="bx bx-file"></i>Data Unsur Kontingen</a></li>
            </ul>
            <!-- Menu DKR End -->

            @elseif (auth()->user()->role_id == 3)
            <!-- Menu DKC Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Dashboards')</li>
                <li><a href="/admin" class="waves-effect"> <i class="bx bx-home-circle"></i> <span key="t-dashboards">@lang('translation.Dashboards')</span> </a> </li>
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>
                <li><a href="{{ route('admin-data-berkas-kontingen.index') }}" key="t-user-grid"> <i class="bx bx-file"></i>Data Berkas Kontingen</a></li>
                <li><a href="{{ route('admin-data-unsur-kontingen.index') }}" key="t-user-grid"> <i class="bx bx-user-circle"></i>Data Unsur Kontingen</a></li>
                <li><a href="{{ route('admin-data-pembayaran.index') }}" key="t-user-grid"> <i class="bx bx-dollar-circle"></i>Bukti Pembayaran</a></li>
                <li><a href="{{ route('admin-data-peserta.index') }}" key="t-user-list"> <i class="bx bx-user"></i>Data Peserta</a></li>
            </ul>
            <!-- Menu DKC End -->

            @endif
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->