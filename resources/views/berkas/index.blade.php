@extends('layouts.master')

@section('title', 'Berkas')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Berkas
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-5">Berkas</h4>

                    @if (auth()->user()->role_id != 1 && count($berkas->where('user_id', auth()->user()->id)) == null)
                        <div class="card-title mb-5">
                            <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2"
                                data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add
                                Berkas</button>
                        </div>
                    @endif

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

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">File</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Catatan Dokumen</th>
                                <th class="text-center">Post By</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($berkas as $key => $data)
                                <tr>
                                    <td class="text-center">{{ ++$key }}</td>
                                    <td class="text-center">{{ $data->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ Storage::URL('public/berkas') }}/{{ $data->filename }}" target="_blank">
                                            {{ $data->file }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($data->status->name == 'Terkirim')
                                            <span class="badge bg-primary">Terkirim</span>
                                        @elseif ($data->status->name == 'Revisi')
                                            <span class="badge bg-warning">Revisi</span>
                                        @elseif ($data->status->name == 'Ditolak')
                                            <span class="badge bg-danger">Revisi</span>
                                        @elseif ($data->status->name == 'Diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $data->catatan }}</td>
                                    <td class="text-center">{{ $data->user->name }}</td>
                                    <td class="text-center">
                                        @if (
                                            (auth()->user()->role_id == 1 || auth()->user()->role_id == 4 && $data->status->name == 'Terkirim') ||
                                                $data->status->name == 'Ditolak' ||
                                                $data->status->name == 'Revisi')
                                            <button type="button" class="btn btn-info btn-sm mr-2 waves-effect waves-light"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-verifikasi-{{ $data->id }}"><i
                                                    class=" bx bx-check-circle"></i> Verifikasi</button>
                                        @endif
                                        @if (auth()->user()->role_id != 1)
                                            @include('layouts.edit-delete-button')
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <!-- Start modal add -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin-data-berkas-kontingen.store') }}" method="POST"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="validationCustom02" class="form-label">Nama Berkas</label>
                            <input class="form-control" placeholder="Surat Tugas" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="validationCustom02" class="form-label">File</label>
                            <input name="file" type="file" class="form-control" id="validationCustom02"
                                value="{{ old('File') }}" required accept=".pdf">
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

    @foreach ($berkas as $data)
        <!-- Start Edit Modal -->
        <div class="modal fade" id="modal-edit-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @include('berkas.edit')
                </div>
            </div>
        </div>
        <!-- End Edit Modal -->

        <!-- Start Delete Modal -->
        <div class="modal fade" id="modal-delete-{{ $data->id }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin-data-berkas-kontingen.destroy', $data->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>Are you Sure?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Delete Modal -->

        <!-- Start Verifikasi Modal -->
        <div class="modal fade" id="modal-verifikasi-{{ $data->id }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Verifikasi Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('berkas.verifikasi', $data->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Verifikasi Dokumen</label>
                                <select name="status_id" class="form-select" id="validationCustom02">
                                    <option disabled selected>--- Silahkan Verifikasi Dokumen ---</option>
                                    @foreach ($status as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $data->status_id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Catatan Untuk Dokumen</label>
                                <input type="text" name="catatan" class="form-control" value="{{ $data->catatan }}"
                                    placeholder="Silahkan isi jika perlu...">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
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
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
