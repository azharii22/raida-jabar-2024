@extends('viewUser.layouts.master')

@section('title', 'Tentang')

@section('content')


   <!-- About Start -->
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="section-title position-relative pb-3 mb-5">
                    <h5 class="fw-bold text-primary text-uppercase">Tentang Raimuna Jabar 2024</h5>
                </div>
                <p class="mb-4" style="text-align: justify">
                Raimuna adalah pertemuan Pramuka Penegak dan Pandega, 
                berasal dari bahasa Ambai di Papua yang berarti "sekumpulan orang dengan 
                tujuan tertentu" dan "kekuatan bernilai baik untuk kesuskesan."
                Raimuna dirancang untuk pengembangan diri, peningkatan kualitas, dan kemajuan generasi muda.
                
                Raimuna Daerah Jawa Barat XIV Tahun 2024 akan berlangsung di Bumi Perkemahan 
                Pramuka Letjen TNI (Purn) Dr. (HC) Mashudi, Kiarapayung, Sumedang, 
                dari 16 hingga 21 September 2024.
                </p>
                {{-- <!-- <div class="row g-0 mb-3">
                    <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                        <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Award Winning</h5>
                        <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Professional Staff</h5>
                    </div>
                    <div class="col-sm-6 wow zoomIn" data-wow-delay="0.4s">
                        <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>24/7 Support</h5>
                        <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Fair Prices</h5>
                    </div>
                </div> -->
                <!-- <div class="d-flex align-items-center mb-4 wow fadeIn" data-wow-delay="0.6s">
                    <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                        <i class="fa fa-phone-alt text-white"></i>
                    </div>
                    <div class="ps-4">
                        <h5 class="mb-2">Call to ask any question</h5>
                        <h4 class="text-primary mb-0">+012 345 6789</h4>
                    </div>
                </div> -->
                <!-- <a href="quote.html" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.9s">Request A Quote</a> --> --}}
            </div>
            <div class="col-lg-5" style="min-height: 100%;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="{{URL::asset('assets/viewUser/img/raida/Header.png')}}">
                </div>
            </div>

            {{-- <div class="col-lg-12">
                <div class="section-title position-relative pb-3">
                    <h5 class="fw-bold text-primary text-uppercase">Teaser Peran Saka Jabar 2023</h5>
                </div>
                <video controls style="margin: 0px; width: 100%; height: 100%; display: block; background-color: #fff;">
                <source src="{{URL::asset('assets/images/peransaka/Teaser HD.mp4')}}" type="video/mp4"></video>
            </div>

            <div class="col-lg-12">
                <div class="section-title position-relative pb-3" style="padding-top: 50px;">
                    <h5 class="fw-bold text-primary text-uppercase">Theme Song Peran Saka Jabar 2023</h5>
                </div>
                <audio controls autoplay style="padding-top: 30px;">
                    <source src="{{URL::asset('assets/images/peransaka/song.mp3')}}" type="audio/mpeg">
                </audio>
            </div> --}}

        </div>
    </div>
</div>
{{-- <!-- About End --> --}}
@endsection
