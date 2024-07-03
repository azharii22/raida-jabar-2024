@extends('layouts.master')

@section('title', 'Peserta')

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Peserta @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Peserta</h4>
                
                <div class="card-title mb-5">
                    <a href="{{ route('admin-data-peserta.index') }}" type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2"> <i class="bx bx-undo"></i> Back To Peserta</a>
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
                    <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th class="text-center">Nama Wilayah</th>
                                <th class="text-center">Jumlah Pendaftar</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($villages as $i =>$data)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="text-uppercase text-center">{{ $data->name }}</td>
                                <td class="text-uppercase text-center">{{ count($peserta->where('villages_id', $data->id)) }} Peserta</td>
                                <td class="text-center">
                                    <a href="{{ route('admin-data-peserta.detailVillages',$data->id) }}" class="btn btn-success waves-effect waves-light btn-sm mr-2"> Lihat <i class="bx bx-right-arrow-alt"></i></a>
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
@endsection