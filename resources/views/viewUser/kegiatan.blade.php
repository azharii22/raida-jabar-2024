@extends('viewUser.layouts.master')

@section('title', 'Kegiatan')

@section('content')

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <div class="fw-bold text-primary text-uppercase">
                    <h5>Daftar Kegiatan {{ config('settings.main.1_app_name') }} Jabar </h5>
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </div>
            </div>
            <div class="row g-5">
                @foreach ($kegiatan as $data)
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-item bg-header rounded d-flex flex-column align-items-center justify-content-center text-center"
                            style="color: white">
                            <div class="d-flex mb-5">
                                <h2 class="text-capitalize">{{ $data->judul }}</h2>
                            </div>
                            <p class="m-0 mb-3 text-capitalize" style="color: white">{!! $data->item_giat !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {!! $kegiatan->appends(['sort' => 'update_at', 'desc'])->links('vendor.pagination.bootstrap-5') !!}
@endsection
