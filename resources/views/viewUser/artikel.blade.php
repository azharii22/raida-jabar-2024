@extends('viewUser.layouts.master')

@section('title', 'Artikel')

@section('content')

    <!-- Blog Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Artikel {{ config('settings.main.1_app_name') }} Jabar 2024</h5>
            </div>
            <div class="row g-5">
                <!-- Blog list Start -->
                <div class="col-lg-8">
                    <div class="row g-5">
                        @foreach ($artikel as $data)
                            <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                                <div class="blog-item bg-light rounded overflow-hidden">
                                    <div class="blog-img position-relative overflow-hidden text-capitalize">
                                        <img class="img-fluid"
                                            src="{{ isset($data->foto) ? Storage::url('public/img/artikel/') . $data->foto : asset('/assets/images/no-image.png') }}"
                                            style="height: 200px; text-align: center;" alt="">
                                        <a class="position-absolute bottom-0 start-0 text-white mb-0 py-2 px-4"
                                            href="{{ route('viewUser.show-artikel', $data->slug) }}"
                                            style="background-color: rgb(227, 145, 62, 0.76);">{{ $data->judul }}</a>
                                    </div>
                                    <div class="p-4">
                                        <div class="d-flex mb-3">
                                            <small class="me-3 text-capitalize"><i
                                                    class="far fa-user text-primary me-2"></i>{{ $data->user->name }}</small>
                                            <small><i
                                                    class="far fa-calendar-alt text-primary me-2"></i>{{ date('d-m-Y', strtotime($data->created_at)) }}</small>
                                        </div>
                                        <h4 class="mb-3 text-capitalize">{{ $data->deskripsi }}</h4>
                                        <p>{{ substr(strip_tags($data->isi_artikel), 0, 100) }}</p>
                                        <a class="text-uppercase"
                                            href="{{ route('viewUser.show-artikel', $data->slug) }}">Read More <i
                                                class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {!! $artikel->appends(['sort' => 'update_at', 'desc'])->links('vendor.pagination.bootstrap-5') !!}
                        </div>
                    </div>
                </div>
                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Recent Post Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">5 Recent Post</h3>
                        </div>
                        @foreach ($artikelDesc as $data)
                        <hr />
                            <div class="d-flex rounded overflow-hidden mb-3">
                                <img class="img-fluid"
                                    src="{{ isset($data->foto) ? Storage::url('public/img/artikel/') . $data->foto : asset('/assets/images/no-image.png') }}"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                <a href="{{ route('viewUser.show-artikel', $data->slug) }}"
                                    class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">{{ $data->judul }}</a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Recent Post End -->
                    <hr />
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Blog End -->
@endsection
