@extends('viewUser.layouts.master')

@section('title', 'Tentang')

@section('content')

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">Tentang Raimuna Jabar 2024</h5>
                    </div>
                    <p class="mb-4" style="text-align: justify">
                        @if ($tentang == null)
                            Silahkan Isi Dahulu di Admin
                        @else
                            {!! $tentang->name !!}
                        @endif
                    </p>
                </div>
                <div class="col-lg-5" style="min-height: 100%;">
                    <div class="position-relative h-100">
                        @if ($tentang == null)
                            Silahkan Isi Dahulu di Admin
                        @else
                            <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                                src="{{ Storage::url('viewUser/img/tentang/' . $tentang->foto) ? Storage::url('viewUser/img/tentang/' . $tentang->foto) : asset('/assets/viewUser/img/raida/Header.png') }}">
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
