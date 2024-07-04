@extends('viewUser.layouts.master')

@section('title', 'Media Unduh')

@section('content')

    <div class="container-xxl py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Media Unduh</h6>
                <h2 class="mt-2">Media Unduh {{ config('settings.main.1_app_name') }}</h2>
            </div>
            <div class="row g-4">
                @foreach ($media as $data)
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-file-pdf fa-2x"></i>
                            </div>
                            <h5 class="mb-3">{{ $data->name }}</h5>
                            <a class="btn px-3 mt-auto mx-auto" href="{{ Storage::url('dokumenPenting/'.$data->filename) }}" target="_blank">Download</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
