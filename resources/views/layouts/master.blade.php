<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ config('settings.main.1_app_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('settings.main.1_app_name') }}" name="author" />
    <meta content="{{ config('settings.main.2_app_description') }}" style="border-radius: 20px" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Storage::url('public/setting' . '/' . config('settings.main.3_app_logo')) }}">
    @include('layouts.head-css')
</head>

@section('body')

    <body data-sidebar="dark">
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <div id="profileModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formrow-nama-input" class="form-label">Nama</label>
                            <input name="name" type="text" class="form-control" id="formrow-nama-input"
                                value="{{ auth()->user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="formrow-nama-input" class="form-label">Nama Lengkap</label>
                            <input name="fullname" type="text" class="form-control" id="formrow-nama-input"
                                value="{{ auth()->user()->fullname }}">
                        </div>
                        <div class="mb-3">
                            <label for="formrow-email-input" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="formrow-email-input"
                                value="{{ auth()->user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="formrow-foto-input" class="form-label">Change Avatar</label>
                            <input name="foto" type="file" class="form-control" id="formrow-foto-input">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    @include('sweetalert::alert')
</body>

</html>
