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
                                @if ($data->key == 'main.3_app_logo')
                                <span>Logo Aplikasi</span>
                                @elseif ($data->key == 'main.6_app_sidebar_color')
                                <span>Warna Sidebar</span>
                                @elseif ($data->key == 'main.7_app_background_color')
                                <span>Warna Background Aplikasi</span>
                                @elseif ($data->key == 'main.4_app_login_image')
                                <span>Logo Login</span>
                                @elseif ($data->key == 'main.5_app_sidebar_image')
                                <span>Logo Sidebar</span>
                                @elseif ($data->key == 'main.1_app_name')
                                <span>Nama Aplikasi</span>
                                @elseif ($data->key == 'main.2_app_description')
                                <span>Deskripsi Aplikasi</span>
                                @endif
                            </td>
                            <td>
                                {{ $data->value }}
                                @if ($data->key == 'main.6_app_sidebar_color')
                                <input class="form-control form-control-color mw-100" type="color" value="#556ee6" id="example-color-input">
                                @endif
                            </td>
                            <td class="text-center">
                                @include('layouts.edit-delete-button')
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- Start Edit Modal -->
@foreach ($setting as $data)
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