@extends('layouts.master')

@section('title', 'Artikel')

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Artikel @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Artikel</h4>
                <div class="card-title mb-5">
                    <a href="{{ route('createArtikel') }}" class="btn btn-primary waves-effect waves-light mb-3"><i class="bx bx-plus"></i> Add Artikel</a>
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
                            <th>Post By</th>
                            <th>Foto</th>
                            <th style="width: 10px;">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($artikel as $i =>$data)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $data->judul }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>
                                <a href="{{ Storage::url('public/img/artikel/').$data->foto }}" target="_blank">
                                    <img class="rounded-circle header-profile-user" src="{{ isset($data->foto) ? asset(Storage::url('public/img/artikel/').$data->foto) : asset('/assets/images/users/avatar-icon.webp') }}" id="formrow-foto-input" width="50px" height="50px" alt="">
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('readArtikel',$data->slug) }}" class="btn btn-info waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="bx bx-bullseye"></i> Show</a>
                                <a href="{{ route('editArtikel',$data->slug) }}" class="btn btn-warning waves-effect waves-light btn-sm mr-2"> <i class="bx bx-pencil"></i> Edit</a>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"> <i class="bx bx-trash"></i> Delete</button>
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
@foreach ($artikel as $data)
<div class="modal fade" id="modal-delete-{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-artikel.destroy', $data->slug) }}" method="POST">
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
@endforeach
<!-- End modal Delete -->
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