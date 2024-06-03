@extends('layouts.master')

@section('title', 'Pembayaran')

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Pembayaran @endslot
@endcomponent

@if (auth()->user()->role_id == "1")

<div class="row">
    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Peserta & Unsur Kontingen</p>
                        <h4 class="mb-0">{{ count($pembayaran) }} Orang</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-user font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Terdaftar</p>
                        <h4 class="mb-0">{{ $terdaftar }} Orang</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-user font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Nominal</p>
                        <h4 class="mb-0">@currency($nominal)</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-money font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div>
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#myModal"> <i class="bx bx-plus"></i>
                        Add Pembayaran
                    </button>
                </div>

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

                <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Form Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin-data-pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="status" value="terkirim">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Jumlah Terdaftar</label>
                                        <input name="jumlah_terdaftar" type="number" class="form-control" id="formrow-nama-input" value="{{ old('jumlah_terdaftar') }}" placeholder="Jumlah Terdaftar">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Nominal</label>
                                        <input name="nominal" type="number" class="form-control" id="formrow-nama-input" value="{{ old('nominal') }}" placeholder="Nominal">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formrow-jk" class="form-label">Upload Bukti Pembayaran</label>
                                        <input name="file" type="file" class="form-control" id="formrow-nama-input" accept=".jpg,.png,.jpeg">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th style="width: 10px;">Nama</th>
                            <th style="width: 10px;">Jumlah Terdaftar</th>
                            <th style="width: 10px;">Nominal</th>
                            <th style="width: 10px;">Status</th>
                            <th style="width: 10px;" class="text-center">Bukti Pembayaran</th>
                            <th style="width: 10px;">Tanggal Upload</th>
                            <th style="width: 10px;">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($pembayaran as $i =>$data)
                        <tr>
                            <td style="width: 10px;"> {{ ++$i }} </td>
                            <td style="width: 10px;"> {{ $data->user->name }} </td>
                            <td style="width: 10px;"> {{ $data->jumlah_terdaftar }} </td>
                            <td style="width: 10px;"> @currency($data->nominal) </td>
                            <td style="width: 10px;">
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
                            <td style="width: 10px;" class="text-center"><a class="btn btn-primary btn-sm mr-2" href="{{ Storage::url('public/pembayaran/').$data->file }}" target="_blank"><i class="bx bx-show"></i> Lihat</a></td>
                            <td style="width: 10px;">{{ date('d-F-Y H:i',strtotime($data->tanggal_upload)) }}</td>
                            <td class="text-center" style="width: 10px;">
                                <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $data->id }}"> <i class="bx bx-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"> <i class="bx bx-trash"></i> Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
@endif

@if (auth()->user()->role_id == "2")

<div class="row">
    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Peserta</p>
                        <h4 class="mb-0">{{ count($pembayaran) }} Orang</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-user font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Terdaftar</p>
                        <h4 class="mb-0">{{ $terdaftar }} Orang</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-user font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Nominal</p>
                        <h4 class="mb-0">@currency($nominal)</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-money font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div>
                    <a href="{{ route('export-pembayaran') }}" class="btn btn-success waves-effect waves-light mb-3" target="_blank"><i class="fa fa-file-excel"></i> Export Excel</a>

                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th style="width: 10px;">Nama</th>
                                <th style="width: 10px;">Jumlah Terdaftar</th>
                                <th style="width: 10px;">Nominal</th>
                                <th style="width: 10px;">Status</th>
                                <th style="width: 10px;" class="text-center">Bukti Pembayaran</th>
                                <th style="width: 10px;">Tanggal Upload</th>
                                <th style="width: 10px;">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($pembayaran as $i =>$data)
                            <tr>
                                <td style="width: 10px;">{{ ++$i }}</td>
                                <td style="width: 10px;">{{ $data->user?->name }}</td>
                                <td style="width: 10px;">{{ $data->jumlah_terdaftar }}</td>
                                <td style="width: 10px;">@currency($data->nominal)</td>
                                <td style="width: 10px;">
                                    @if ($data->status === 'terkirim')
                                    <span class="badge text-bg-primary">Terkirim</span>
                                    @elseif ($data->status === 'diterima')
                                    <span class="badge text-bg-success">Diterima</span>
                                    @elseif ($data->status === 'revisi')
                                    <span class="badge text-bg-warning">Revisi</span>
                                    @elseif ($data->status === 'ditolak')
                                    <span class="badge text-bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td style="width: 10px;" class="text-center"><a href="{{ Storage::url('public/img/pembayaran/').$data->file_bukti_bayar }}" target="_blank"><img src="{{ Storage::url('public/img/pembayaran/').$data->file_bukti_bayar }}" width="100" height="100" /></a></td>
                                <td style="width: 10px;">{{ date('d-M-Y',strtotime($data->tanggal_upload)) }}</td>
                                <td class="text-center" style="width: 10px;">
                                    @if ($data->status->name === 'Revisi' || $data->status->name === 'Terkirim' || $data->status->name === 'Ditolak')
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-status-{{ $data->id }}"> <i class="bx bx-pencil"></i> Update Status</button>
                                    @else
                                    <span class="badge text-bg-success"><i class="bx bx-minus"></i> </span>
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

@endif

<!-- Start modal Delete-->
@foreach ($pembayaran as $data)
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-edit-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-pembayaran.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="terkirim">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Jumlah Terdaftar</label>
                        <input name="jumlah_terdaftar" type="number" class="form-control" id="formrow-nama-input" value="{{ $data->jumlah_terdaftar }}">
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Nominal</label>
                        <input name="nominal" type="number" class="form-control" id="formrow-nama-input" value="{{ $data->nominal }}">
                    </div>
                    <div class="mb-3">
                        <label for="formrow-jk" class="form-label">Upload Bukti Pembayaran</label>
                        <input name="file_bukti_bayar" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-delete-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-pembayaran.destroy', $data->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="mb-3">
                        <p> Apakah {{ auth()->user()->nama }} ingin menghapus data? </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-status-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('verifikasiPembayaran', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="formrow-nama-input" placeholder="{{ $data->user?->nama }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Pilih Status</label>
                        <select name="status" class="form-control" id="formrow-jk">
                            <option disabled selected>--- Verifikasi Status ---</option>
                            <option value="diterima" {{ "diterima" == $data->status ? 'selected' : '' }}>Diterima</option>
                            <option value="revisi" {{ "revisi" == $data->status ? 'selected' : '' }}>Revisi</option>
                            <option value="ditolak" {{ "ditolak" == $data->status ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Catatan</label>
                        <textarea type="catatan" class="form-control" id="formrow-nama-input" placeholder="Isi Catatan Jika Perlu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update Status</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endforeach

@endsection

@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
<!-- Datatable init js -->
<script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection