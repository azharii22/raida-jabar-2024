@extends('viewUser.layouts.master')

@section('title', 'Photo Dokumentasi')

@section('content')

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">{{ count($photo) }} Dokumentasi </h5>
            </div>
            <div class="row g-5">
                @foreach ($photo as $data)
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div
                            class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="mb-5">
                                <img class="img-fluid" src="{{ url('uploads/gallery/', $data->filename) }}"
                                    style="height: 200px; text-align: center;" alt="">
                            </div>
                            <a class="btn2 btn-lg btn-primary rounded" href="{{ route('viewUserDownloadPhoto', $data->id) }}"
                                target="_blank">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
