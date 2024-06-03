@extends('layouts.master')

@section('title', 'Dokumentasi')

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dasboard @endslot
@slot('title') Dokumentasi @endslot
@endcomponent

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">Dokumentasi</h4>
                <div class="card-title mb-5">
                    <a href="{{ route('admin-dokumentasi-kegiatan.index') }}" type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2"> <i class="bx bx-left-arrow-alt"></i> Back To Dokumentasi</a>
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
                            <th>Photo</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($data as $i => $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->dokumentasi->judul }}</td>
                            <td>
                                <a href="{{ URL::asset('uploads/gallery') }}/{{$item->filename}}" target="_blank">
                                    <img class="rounded-circle header-profile-user" src="{{ URL::asset('uploads/gallery') }}/{{$item->filename}}" id="formrow-foto-input" width="50px" height="50px" alt="">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Start modal Delete-->
@foreach ($data as $item)
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-delete-{{ $item->id }}">
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
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
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