@extends('viewUser.layouts.master')

@section('title', 'Dokumentasi')

@section('content')

<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">Dokumentasi {{ config('settings.main.1_app_name') }} 2024</h5>
        </div>
        <div class="row g-5">
            @foreach ($dokumentasi as $data)
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="d-flex mb-3">
                        <small><i class="far fa-calendar-alt text-primary me-2"></i>{{ date('d-M-Y', strtotime($data->created_at)) }}</small>
                    </div>
                    <div class="mb-5">
                        <img class="img-fluid" src="{{ isset($data->cover) ? asset(Storage::url('public/img/dokumentasi/cover/').$data->cover) : asset('/assets/images/users/avatar-icon.webp') }}" style="height: 100px; text-align: center;" alt="">
                    </div>
                    <h4 class="m-0 mb-3 text-capitalize">{{ $data->judul }}</h4>
                    <a class="btn2 btn-lg btn-primary rounded" href="{{ route('viewUserPhoto', $data->id) }}" target="_blank">
                        <i class="bi bi-eye"></i> 
                        &nbsp; Lihat
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{!! $dokumentasi->appends(['sort' => 'update_at', 'desc'])->links('vendor.pagination.bootstrap-5') !!}
@endsection
