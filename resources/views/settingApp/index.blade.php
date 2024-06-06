@extends('layouts.master')

@section('title', 'Setting Application')
@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Setting @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Setting Aplikasi</h4>

                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible fade show mt-3 mb-5" role="alert">
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
                            <th class="text-center">Value</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($setting as $key => $data)
                        <tr>
                            <td class="text-center">{{ ++$key }}</td>
                            <td>
                                @if ($data->key == 'main.1_app_name')
                                <span>Nama Aplikasi</span>
                                @elseif ($data->key == 'main.2_app_description')
                                <span>Deskripsi Aplikasi</span>
                                @elseif ($data->key == 'main.3_app_logo')
                                <span>Logo Aplikasi</span>
                                @endif
                            </td>
                            <td>
                                @if ($data->key === 'main.3_app_logo')
                                <img src="{{ Storage::url('public/setting'.'/'.$data->value) }}" width="150px" height="150px" style="border-radius: 20px">
                                @else
                                {{ $data->value }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($data->key != 'main.3_app_logo')
                                @include('layouts.edit-delete-button')
                                @else
                                <button type="button" class="btn btn-warning btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-file-{{ $data->id }}"><i class=" bx bx-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"><i class=" bx bx-trash"></i> Delete</button>
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
@foreach ($setting as $data)
<!-- Start Edit Modal -->
<div class="modal fade" id="modal-edit-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @include('settingApp.edit')
        </div>
    </div>
</div>
<!-- End Edit Modal -->

<!-- Start File Modal -->
<div class="modal fade" id="modal-file-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-setting.file' ,$data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Value</label>
                        <input type="file" class="form-control" id="validationCustom02" name="value" required accept=".jpg, .png, .jpeg, .svg, .gif">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End File Modal -->

<!-- Start Delete Modal -->
<div class="modal fade" id="modal-delete-{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-settings.destroy', $data->id) }}" method="POST">
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