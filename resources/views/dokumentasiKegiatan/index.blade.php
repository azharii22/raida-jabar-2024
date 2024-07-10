@extends('layouts.master')

@section('title', 'Dokumentasi')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dasboard
        @endslot
        @slot('title')
            Dokumentasi
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Dokumentasi</h4>
                    <div class="card-title mb-5">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2"
                            data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add
                            Dokumentasi</button>
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

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Cover</th>
                                <th style="width: 10px;">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($data as $i => $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td><a href="{{ Storage::url('public/img/dokumentasi/cover/') . $item->cover }}"
                                            target="_blank">
                                            <img class="rounded-circle header-profile-user"
                                                src="{{ isset($item->cover) ? asset(Storage::url('public/img/dokumentasi/cover/') . $item->cover) : asset('/assets/images/users/avatar-icon.webp') }}"
                                                id="formrow-foto-input" width="50px" height="50px" alt="">
                                        </a></td>
                                    <td class="text-center">
                                        <a href="{{ route('admin-dokumentasi-kegiatan.show', $item->id) }}"
                                            class="btn btn-light waves-effect waves-light btn-sm mr-2"> <i
                                                class="mdi mdi-eye"></i> View Photo Dokumentasi</a>
                                        <a href="{{ route('addPhotos', $item->id) }}"
                                            class="btn btn-info waves-effect waves-light btn-sm mr-2"> <i
                                                class="bx bx-plus"></i> Add Photos</a>
                                        <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2"
                                            data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $item->id }}"> <i
                                                class="bx bx-pencil"></i> Edit Cover</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2"
                                            data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $item->id }}"> <i
                                                class="bx bx-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <!-- Start modal add -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin-dokumentasi-kegiatan.store') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="false">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formrow-judul-input" class="form-label">Judul</label>
                                    <input name="judul" type="text" class="form-control" id="formrow-judul-input"
                                        placeholder="Judul Dokumentasi" value="{{ old('judul') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formrow-cover-input" class="form-label">Cover</label>
                                    <input name="cover" type="file" class="form-control" id="formrow-cover-input"
                                        placeholder="Cover" value="{{ old('cover') }}">
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

    <!-- start modal edit -->
    @foreach ($data as $i => $item)
        <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
            id="modal-edit-{{ $item->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Form Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin-dokumentasi-kegiatan.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data" autocomplete="false">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="formrow-judul-input" class="form-label">Judul</label>
                                        <input name="judul" type="text" class="form-control"
                                            id="formrow-judul-input" placeholder="Judul Dokumentasi"
                                            value="{{ $item->judul }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="formrow-cover-input" class="form-label">Cover Sebelumnya</label> <br />
                                        <img src="{{ Storage::url('public/img/dokumentasi/cover/') . $item->cover }}" style="height: 150px; width: 150px;" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="formrow-cover-input" class="form-label">Update Cover</label>
                                        <input name="cover" type="file" class="form-control"
                                        id="formrow-cover-input" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- End modal edit -->

        <!-- Start modal Delete-->
        <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
            id="modal-delete-{{ $item->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Delete Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin-dokumentasi-kegiatan.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="mb-3">
                                <p> Apakah {{ auth()->user()->nama }} ingin menghapus data? </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach

@endsection
<!-- End modal Delete -->
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
