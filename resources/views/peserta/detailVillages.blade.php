@extends('layouts.master')

@section('title', 'Peserta')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Peserta
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            Error! <br />
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h4 class="card-title mb-5">Peserta</h4>
                    <div class="card-title mb-5">
                        <a href="{{ route('peserta.excel') }}" type="button"
                            class="btn btn-success waves-effect waves-light btn-sm mr-2" target="_blank"> <i
                                class="mdi mdi-file-excel-outline"></i> Export Excel</a>
                        <a href="{{ route('peserta.pdf') }}" type="button"
                            class="btn btn-danger waves-effect waves-light btn-sm mr-2" target="_blank"> <i
                                class="mdi mdi-file-pdf-outline"></i> Export PDF</a>
                    </div>

                    <div class="table-responsive">
                        <table id='TABLE_1' class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Berkas Peserta</th>
                                    <th>Catatan</th>
                                    <th style="width: 10px;">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($peserta as $i => $data)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td class="text-uppercase">{{ $data->nama_lengkap }}</td>
                                        <td>
                                            @if ($data->jenis_kelamin == 1)
                                                <span>Laki - Laki</span>
                                            @else
                                                <span>Perempuan</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->kategori?->name }}</td>
                                        <td>
                                            @if ($data->status->name === 'Terkirim')
                                                <span class="badge text-bg-primary">Terkirim</span>
                                            @elseif ($data->status->name === 'Diterima')
                                                <span class="badge text-bg-success">Diterima</span>
                                            @elseif ($data->status->name === 'Revisi')
                                                <span class="badge text-bg-warning">Revisi</span>
                                            @elseif ($data->status->name === 'Ditolak')
                                                <span class="badge text-bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->foto != null)
                                                <a class="btn btn-success waves-effect waves-light btn-sm mr-2"
                                                    href="{{ Storage::url('public/img/peserta/foto/') . $data->foto }}"
                                                    target="_blank"><i class="bx bx-check-circle"></i> Foto</a>
                                            @else
                                                <button type="button"
                                                    class="btn btn-warning waves-effect waves-light btn-sm mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-foto-{{ $data->id }}"><i
                                                        class="bx bx-upload"></i> Foto</button>
                                            @endif
                                            @if ($data->KTA != null)
                                                <a class="btn btn-success waves-effect waves-light btn-sm mr-2"
                                                    href="{{ Storage::url('public/img/peserta/kta/') . $data->KTA }}"
                                                    target="_blank"><i class="bx bx-check-circle"></i> KTA</a>
                                            @else
                                                <button type="button"
                                                    class="btn btn-warning waves-effect waves-light btn-sm mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-kta-{{ $data->id }}"><i
                                                        class="bx bx-upload"></i> KTA</button>
                                            @endif
                                            @if ($data->asuransi_kesehatan != null)
                                                <a class="btn btn-success waves-effect waves-light btn-sm mr-2"
                                                    href="{{ Storage::url('public/img/peserta/asuransi-kesehatan/') . $data->asuransi_kesehatan }}"
                                                    target="_blank"><i class="bx bx-check-circle"></i> Asuransi
                                                    Kesehatan </a>
                                            @else
                                                <button type="button"
                                                    class="btn btn-warning waves-effect waves-light btn-sm mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-asuransi-{{ $data->id }}"><i
                                                        class="bx bx-upload"></i> Asuransi Kesehatan </button>
                                            @endif
                                            @if ($data->sertif_sfh != null)
                                                <a class="btn btn-success waves-effect waves-light btn-sm mr-2"
                                                    href="{{ Storage::url('public/img/peserta/sertif-sfh/') . $data->sertif_sfh }}"
                                                    target="_blank"><i class="bx bx-check-circle"></i> Sertif
                                                    SFH</a>
                                            @else
                                                <button type="button"
                                                    class="btn btn-warning waves-effect waves-light btn-sm mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-sertif-{{ $data->id }}"><i
                                                        class="bx bx-upload"></i> Sertif SFH</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->status->name === 'Revisi')
                                                <div style="color: red;">
                                                    <li>{{ $data->catatan }}</li>
                                                </div>
                                            @else
                                                {{ $data->catatan }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->user()->role_id == 1 && $data->status->name != 'Diterima')
                                                <button type="button"
                                                    class="btn btn-info btn-sm mr-2 waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-verifikasi-{{ $data->id }}"><i
                                                        class=" bx bx-check-circle"></i> Verifikasi</button>
                                            @endif
                                            <button type="button"
                                                class="btn btn-light waves-effect waves-light btn-sm mr-2"
                                                data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $data->id }}">
                                                <i class="bx bx-show"></i> Detail</button>
                                            @if (auth()->user()->role_id == 1)
                                                <button type="button"
                                                    class="btn btn-warning waves-effect waves-light btn-sm mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-{{ $data->id }}"> <i
                                                        class="bx bx-pencil"></i> Edit</button>
                                                <button type="button"
                                                    class="btn btn-danger waves-effect waves-light btn-sm mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete-{{ $data->id }}"> <i
                                                        class="bx bx-trash"></i> Delete</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script type="text/javascript" defer="defer">
        $(document).ready(function() {
            $("table[id^='TABLE']").DataTable({});
        });
    </script>
@endsection
