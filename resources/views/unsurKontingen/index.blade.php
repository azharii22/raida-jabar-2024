@extends('layouts.master')

@section('title', 'Unsur Kontingen')

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Unsur Kontingen @endslot
@endcomponent

@if (auth()->user()->role_id == 2)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Unsur Kontingen</h4>

                <div class="card-title mb-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add Peserta</button>
                    <a href="{{ route('unsur-kontingen.excel') }}" type="button" class="btn btn-success waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-excel-outline"></i> Export Excel</a>
                    <a href="{{ route('unsur-kontingen.pdf') }}" type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-pdf-outline"></i> Export PDF</a>
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

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
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
                            @foreach ($unsurKontingen as $i =>$data)
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
                                    @if ($data->foto != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/foto/').$data->foto }}" target="_blank"><i class="bx bx-check-circle"></i> Foto</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-foto-{{ $data->id }}"><i class="bx bx-upload"></i> Foto</button>
                                    @endif
                                    @if ($data->KTA != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/kta/').$data->KTA }}" target="_blank"><i class="bx bx-check-circle"></i> KTA</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-kta-{{ $data->id }}"><i class="bx bx-upload"></i> KTA</button>
                                    @endif
                                    @if ($data->asuransi_kesehatan != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/asuransi-kesehatan/').$data->asuransi_kesehatan }}" target="_blank"><i class="bx bx-check-circle"></i> Asuransi Kesehatan </a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-asuransi-{{ $data->id }}"><i class="bx bx-upload"></i> Asuransi Kesehatan </button>
                                    @endif
                                    @if ($data->sertif_sfh != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/sertif-sfh/').$data->sertif_sfh }}" target="_blank"><i class="bx bx-check-circle"></i> Sertif SFH</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-sertif-{{ $data->id }}"><i class="bx bx-upload"></i> Sertif SFH</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($data->status->name === 'Revisi')
                                    <div style="color: red;">
                                        <li>{{ $data->catatan }}</li>
                                    </div>
                                    @else
                                    {{$data->catatan}}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (auth()->user()->role_id == 1 && $data->status->name != 'Diterima')
                                    <button type="button" class="btn btn-info btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-verifikasi-{{ $data->id }}"><i class=" bx bx-check-circle"></i> Verifikasi</button>
                                    @endif
                                    <button type="button" class="btn btn-light waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $data->id }}"> <i class="bx bx-show"></i> Detail</button>
                                    @if (auth()->user()->role_id != 1)
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $data->id }}"> <i class="bx bx-pencil"></i> Edit</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"> <i class="bx bx-trash"></i> Delete</button>
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
</div>
@elseif (auth()->user()->role_id == 3)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Unsur Kontingen</h4>

                <div class="card-title mb-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add Peserta</button>
                    <a href="{{ route('unsur-kontingen.excel') }}" type="button" class="btn btn-success waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-excel-outline"></i> Export Excel</a>
                    <a href="{{ route('peserta.pdf') }}" type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-pdf-outline"></i> Export PDF</a>
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

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Wilayah</th>
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
                            @foreach ($unsurKontingen as $i =>$data)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="text-uppercase">{{ $data->villages?->name ?  $data->villages?->name : $data->regency->name }}</td>

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
                                    @if ($data->foto != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/foto/').$data->foto }}" target="_blank"><i class="bx bx-check-circle"></i> Foto</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-foto-{{ $data->id }}"><i class="bx bx-upload"></i> Foto</button>
                                    @endif
                                    @if ($data->KTA != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/kta/').$data->KTA }}" target="_blank"><i class="bx bx-check-circle"></i> KTA</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-kta-{{ $data->id }}"><i class="bx bx-upload"></i> KTA</button>
                                    @endif
                                    @if ($data->asuransi_kesehatan != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/asuransi-kesehatan/').$data->asuransi_kesehatan }}" target="_blank"><i class="bx bx-check-circle"></i> Asuransi Kesehatan </a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-asuransi-{{ $data->id }}"><i class="bx bx-upload"></i> Asuransi Kesehatan </button>
                                    @endif
                                    @if ($data->sertif_sfh != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/sertif-sfh/').$data->sertif_sfh }}" target="_blank"><i class="bx bx-check-circle"></i> Sertif SFH</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-sertif-{{ $data->id }}"><i class="bx bx-upload"></i> Sertif SFH</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($data->status->name === 'Revisi')
                                    <div style="color: red;">
                                        <li>{{ $data->catatan }}</li>
                                    </div>
                                    @else
                                    {{$data->catatan}}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (auth()->user()->role_id == 1 && $data->status->name != 'Diterima')
                                    <button type="button" class="btn btn-info btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-verifikasi-{{ $data->id }}"><i class=" bx bx-check-circle"></i> Verifikasi</button>
                                    @endif
                                    <button type="button" class="btn btn-light waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $data->id }}"> <i class="bx bx-show"></i> Detail</button>
                                    @if (auth()->user()->role_id != 1)
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $data->id }}"> <i class="bx bx-pencil"></i> Edit</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"> <i class="bx bx-trash"></i> Delete</button>
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
</div>

@endif

<!-- Start modal add -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-peserta.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Nama Lengkap <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="nama_lengkap" type="text" class="form-control" id="validationCustom02" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <div class="input-group">
                                    <input name="tempat_lahir" type="text" class="form-control" id="validationCustom02" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir" required>
                                    <input name="tanggal_lahir" type="date" class="form-control" id="validationCustom02" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Jenis Kelamin <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option disabled selected>--- Pilih Jenis Kelamin ---</option>
                                    <option value="1" @selected(old('jenis_kelamin')=='1' )>Laki - Laki</option>
                                    <option value="2" @selected(old('jenis_kelamin')=='2' )>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Ukuran Kaos <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="ukuran_kaos">
                                    <option disabled selected>--- Pilih Ukuran Kaos ---</option>
                                    <option value="S" @selected(old('ukuran_kaos')=='S' )>S</option>
                                    <option value="M" @selected(old('ukuran_kaos')=='M' )>M</option>
                                    <option value="L" @selected(old('ukuran_kaos')=='L' )>L</option>
                                    <option value="XL" @selected(old('ukuran_kaos')=='XL' )>XL</option>
                                    <option value="XXL" @selected(old('ukuran_kaos')=='XXL' )>XXL</option>
                                    <option value="XXXL" @selected(old('ukuran_kaos')=='XXXL' )>XXXL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP / WA <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="no_hp" type="number" id="no_hp" value="{{ old('no_hp') }}" placeholder="No HP/ WA" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Kategori <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="kategori_id" id="kategori_id">
                                    <option disabled selected>--- Pilih Kategori ---</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" @selected(old('kategori_id')==$item->id)>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="agama" id="agama">
                                    <option disabled selected>--- Pilih Agama ---</option>
                                    <option value="Islam" @selected(old('agama')=='Islam' )>Islam</option>
                                    <option value="Kristen" @selected(old('agama')=='Kristen' )>Kristen</option>
                                    <option value="Katolik" @selected(old('agama')=='Katolik' )>Katolik</option>
                                    <option value="Hindu" @selected(old('agama')=='Hindu' )>Hindu</option>
                                    <option value="Buddha" @selected(old('agama')=='Buddha' )>Buddha</option>
                                    <option value="Konghucu" @selected(old('agama')=='Konghucu' )>Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="golongan_darah" class="form-label">Golongan Darah <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="golongan_darah">
                                    <option disabled selected>--- Pilih Golongan Darah ---</option>
                                    <option value="A" @selected(old('golongan_darah')=='A' )>A</option>
                                    <option value="B" @selected(old('golongan_darah')=='B' )>B</option>
                                    <option value="O" @selected(old('golongan_darah')=='O' )>O</option>
                                    <option value="AB" @selected(old('golongan_darah')=='AB' )>AB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                <input name="riwayat_penyakit" type="text" id="riwayat_penyakit" value="{{ old('riwayat_penyakit') }}" placeholder="Riwayat Penyakit" class="form-control">
                                <input name="regency_id" value="{{ Auth::user()->regency_id }}" hidden>
                                <input name="villages_id" value="{{ Auth::user()->villages_id }}" hidden>
                            </div>
                        </div>
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
<!-- End modal add -->

@foreach ($unsurKontingen as $data)
<!-- Start modal Edit -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-edit-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-peserta.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Nama Lengkap <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="nama_lengkap" type="text" class="form-control" id="validationCustom02" value="{{ $data->nama_lengkap }}" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <div class="input-group">
                                    <input name="tempat_lahir" type="text" class="form-control" id="validationCustom02" value="{{ $data->tempat_lahir }}" placeholder="Tempat Lahir" required>
                                    <input name="tanggal_lahir" type="date" class="form-control" id="validationCustom02" value="{{ $data->tanggal_lahir }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Jenis Kelamin <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option disabled selected>--- Pilih Jenis Kelamin ---</option>
                                    <option value="1" @selected($data->jenis_kelamin=='1' )>Laki - Laki</option>
                                    <option value="2" @selected($data->jenis_kelamin=='2' )>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Ukuran Kaos <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="ukuran_kaos">
                                    <option disabled selected>--- Pilih Ukuran Kaos ---</option>
                                    <option value="S" @selected($data->ukuran_kaos =='S' )>S</option>
                                    <option value="M" @selected($data->ukuran_kaos =='M' )>M</option>
                                    <option value="L" @selected($data->ukuran_kaos =='L' )>L</option>
                                    <option value="XL" @selected($data->ukuran_kaos =='XL' )>XL</option>
                                    <option value="XXL" @selected($data->ukuran_kaos =='XXL' )>XXL</option>
                                    <option value="XXXL" @selected($data->ukuran_kaos =='XXXL' )>XXXL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP / WA <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="no_hp" type="number" id="no_hp" value="{{ $data->no_hp }}" placeholder="No HP/ WA" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Kategori <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="kategori_id" id="kategori_id">
                                    <option disabled selected>--- Pilih Kategori ---</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" @selected($data->kategori_id==$item->id)>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="agama" id="agama">
                                    <option disabled selected>--- Pilih Agama ---</option>
                                    <option value="Islam" @selected($data->agama=='Islam' )>Islam</option>
                                    <option value="Kristen" @selected($data->agama=='Kristen' )>Kristen</option>
                                    <option value="Katolik" @selected($data->agama=='Katolik' )>Katolik</option>
                                    <option value="Hindu" @selected($data->agama=='Hindu' )>Hindu</option>
                                    <option value="Buddha" @selected($data->agama=='Buddha' )>Buddha</option>
                                    <option value="Konghucu" @selected($data->agama=='Konghucu' )>Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="golongan_darah" class="form-label">Golongan Darah <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="golongan_darah">
                                    <option disabled selected>--- Pilih Golongan Darah ---</option>
                                    <option value="A" @selected($data->golongan_darah =='A' )>A</option>
                                    <option value="B" @selected($data->golongan_darah =='B' )>B</option>
                                    <option value="O" @selected($data->golongan_darah =='O' )>O</option>
                                    <option value="AB" @selected($data->golongan_darah ='AB' )>AB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                <input name="riwayat_penyakit" type="text" id="riwayat_penyakit" value="{{ $data->riwayat_penyakit }}" placeholder="Riwayat Penyakit" class="form-control">
                                <input name="regency_id" value="{{ Auth::user()->regency_id }}" hidden>
                                <input name="villages_id" value="{{ Auth::user()->villages_id }}" hidden>
                            </div>
                        </div>
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
<!-- End modal Edit -->
<!-- Start modal Delete -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-delete-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-peserta.destroy', $data->id) }}" method="POST">
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
<!-- End modal Delete -->

<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-foto-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peserta.foto', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Foto</label>
                        <input name="foto" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-kta-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload KTA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peserta.kta', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload KTA</label>
                        <input name="KTA" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-asuransi-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Asuransi Kesehatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peserta.asuransi', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Asuransi Kesehatan</label>
                        <input name="asuransi_kesehatan" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-sertif-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Sertifikat SFH</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peserta.sertif', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Sertifikat SFH</label>
                        <input name="sertif_sfh" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="modal-detail-{{ $data->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Detail Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td class="w-64">Nama Lengkap</td>
                        <td>:</td>
                        <td>{{ $data->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ $data->tempat_lahir }},{{ date('d-M-y', strtotime($data->tanggal_lahir)) }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            @if ($data->jenis_kelamin == 1)
                            <span>Laki - Laki</span>
                            @else
                            <span>Perempuan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ukuran Kaos</td>
                        <td>:</td>
                        <td>{{ $data->ukuran_kaos }}</td>
                    </tr>
                    <tr>
                        <td>No HP</td>
                        <td>:</td>
                        <td>{{ $data->no_hp }}</td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>:</td>
                        <td>{{ $data->kategori?->name }}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td>{{ $data->agama }}</td>
                    </tr>
                    <tr>
                        <td>Golongan Darah</td>
                        <td>:</td>
                        <td>{{ $data->golongan_darah }}</td>
                    </tr>
                    <tr>
                        <td>Riwayat Penyakit</td>
                        <td>:</td>
                        <td>{{ $data->riwayat_penyakit ? $data->riwayat_penyakit : '-' }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table class="border-collapse border border-slate-400 w-full">
                                <thead>
                                    <tr>
                                        <th class="w-64">Foto</th>
                                        <th class="w-64">KTA</th>
                                        <th class="w-64">Asuransi</th>
                                        <th class="w-64">Sertif SFH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->foto) ? asset(Storage::url('public/img/peserta/foto/').$data->foto) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->KTA) ? asset(Storage::url('public/img/peserta/kta/').$data->KTA) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->asuransi_kesehatan) ? asset(Storage::url('public/img/peserta/asuransi-kesehatan/').$data->asuransi_kesehatan) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->sertif_sfh) ? asset(Storage::url('public/img/peserta/sertif-sfh/').$data->sertif_sfh) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Start Verifikasi Modal -->
<div class="modal fade" id="modal-verifikasi-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Verifikasi Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peserta.verifikasi', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Verifikasi Dokumen</label>
                        <select name="status_id" class="form-select" id="validationCustom02">
                            <option disabled selected>--- Silahkan Verifikasi Dokumen ---</option>
                            @foreach ($status as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $data->status_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Catatan Untuk Dokumen</label>
                        <input type="text" name="catatan" class="form-control" value="{{ $data->catatan }}" placeholder="Silahkan isi jika perlu...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Verifikasi Modal -->
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