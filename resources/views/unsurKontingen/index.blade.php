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

@if (auth()->user()->role_id == 1)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Unsur Kontingen</h4>

                <div class="card-title mb-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add Unsur Kontingen</button>
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
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/').$data->foto }}" target="_blank"><i class="bx bx-check-circle"></i> Foto</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-foto-{{ $data->id }}"><i class="bx bx-upload"></i> Foto</button>
                                    @endif
                                    @if ($data->kta != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/').$data->kta }}" target="_blank"><i class="bx bx-check-circle"></i> KTA</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-kta-{{ $data->id }}"><i class="bx bx-upload"></i> KTA</button>
                                    @endif
                                    @if ($data->asuransi_kesehatan != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/').$data->asuransi_kesehatan }}" target="_blank"><i class="bx bx-check-circle"></i> Asuransi</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-askes-{{ $data->id }}"><i class="bx bx-upload"></i> Asuransi</button>
                                    @endif
                                    @if ($data->sertif_sfh != NULL)
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="{{ Storage::url('public/img/peserta/').$data->sertif_sfh }}" target="_blank"><i class="bx bx-check-circle"></i> Sertif SFH</a>
                                    @else
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-sertif-sfh-{{ $data->id }}"><i class="bx bx-upload"></i> Sertif SFH</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($data->status->name === 'Revisi')
                                    <div style="color: red;">
                                        <li>{{ $data->catatan }}</li>
                                    </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $data->id }}"> <i class="bx bx-show"></i> Detail</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $data->id }}"> <i class="bx bx-pencil"></i> Edit</button>
                                    @if ($data->status->name === 'Revisi')
                                    @endif
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"> <i class="bx bx-trash"></i> Delete</button>
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
@else
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Nama</th>
                                <th>Partisipan</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($unsurKontingen as $i =>$data)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="text-uppercase">{{ $data->nama }}</td>
                                <td>{{ $data->partisipan->count('user_id') }} Orang</td>
                                <td align="center">
                                    <a href="{{ route('detailPeserta', $data->id) }}" class="btn btn-info waves-effect waves-light btn-sm mr-2"> <i class="bx bx-show"></i> Detail</a>
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

<!-- Start modal add -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-unsur-kontingen.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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
                                <input name="ukuran_kaos" type="text" class="form-control" id="validationCustom02" value="{{ old('ukuran_kaos') }}" placeholder="Ukuran Kaos" required>
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
                                <input name="golongan_darah" type="text" id="golongan_darah" value="{{ old('golongan_darah') }}" placeholder="Golongan Darah" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                <input name="riwayat_penyakit" type="text" id="riwayat_penyakit" value="{{ old('riwayat_penyakit') }}" placeholder="Riwayat Penyakit" class="form-control">
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

<!-- Start modal Delete-->
@foreach ($unsurKontingen as $data)
<!-- Start modal Edit -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-edit-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-unsur-kontingen.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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
                                <input name="ukuran_kaos" type="text" class="form-control" id="validationCustom02" value="{{ $data->ukuran_kaos }}" placeholder="Ukuran Kaos" required>
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
                                <input name="golongan_darah" type="text" id="golongan_darah" value="{{ $data->golongan_darah }}" placeholder="Golongan Darah" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                <input name="riwayat_penyakit" type="text" id="riwayat_penyakit" value="{{ $data->riwayat_penyakit }}" placeholder="Riwayat Penyakit" class="form-control">
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
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-delete-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-data-unsur-kontingen.destroy', $data->id) }}" method="POST">
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
            <form action="{{ route('unsur-kontingen.foto', $data->id) }}" method="POST" enctype="multipart/form-data">
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
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-vaksin-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Vaksin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('unsur-kontingen.vaksin', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Vaksin</label>
                        <input name="kta" type="file" class="form-control" id="formrow-nama-input">
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
            <form action="{{ route('unsur-kontingen.kta', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload KTA</label>
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
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-asuransi-{{ $data->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Asuransi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('unsur-kontingen.asuransi', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Asuransi</label>
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
                                            <img style="border-radius: 10px;" src="{{ isset($data->foto) ? asset(Storage::url('public/img/peserta/').$data->foto) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->kta) ? asset(Storage::url('public/img/peserta/').$data->kta) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->asuransi_kesehatan) ? asset(Storage::url('public/img/peserta/').$data->asuransi_kesehatan) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="{{ isset($data->sertif_sfh) ? asset(Storage::url('public/img/peserta/').$data->sertif_sfh) : asset('/assets/images/x.png') }}" id="formrow-foto-input" width="100px" height="100px" alt="">
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