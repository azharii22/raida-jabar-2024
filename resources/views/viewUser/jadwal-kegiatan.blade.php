@extends('viewUser.layouts.master')

@section('title', 'Jadwal Kegiatan')

@section('content')


    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <div class="fw-bold text-primary text-uppercase">
                    <h5>Jadwal Kegiatan {{ config('settings.main.1_app_name') }} Jabar</h5>
                    <script> document.write(new Date().getFullYear()) </script>
                </div>
            </div>
            <div class="row g-5">
                @foreach ($jadwalKegiatan as $data)
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div
                            class="service-item rounded d-flex flex-column align-items-center justify-content-center text-center">
                            <h6>Tanggal Kegiatan : </h6>
                            <div class="d-flex mb-3">
                                <h6><i
                                        class="far fa-calendar-alt text-primary me-2"></i>{{ date('d-m-Y', strtotime($data->created_at)) }}
                                </h6>
                            </div>
                            <div class="mb-5">
                                {{-- <i class="fa fa-file-pdf text-white"></i> --}}
                                <img src='{{ URL::asset('/images/pdf_logo.png') }}' style="height: 100px; width: 100%;" />
                            </div>
                            <h4 class="m-0 mb-3 text-capitalize">{{ $data->nama }}</h4>
                            <a class="btn2 btn-primary p-2"
                                href="{{ Storage::url('jadwalKegiatan/') . $data->filename }}" target="_blank">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {!! $jadwalKegiatan->appends(['sort' => 'update_at', 'desc'])->links('vendor.pagination.bootstrap-5') !!}

@endsection
