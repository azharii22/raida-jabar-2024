@extends('layouts.master')

@section('title', 'User')

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('title') User @endslot
    @endcomponent

    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">User Management</h4>

                <div class="card-title mb-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add User</button>
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
                            <th class="text-center">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Fullname</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Tempat Tanggal Lahir</th>
                            <th class="text-center">Avatar</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Region</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($user as $key => $data)
                        <tr>
                            <td class="text-center">{{ ++$key }}</td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->fullname }}</td>
                            <td class="text-center">
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                            </td>
                            </a>
                            <td class="text-center">{{ $data->pob }}, {{date('d-M-Y', strtotime($data->dob))}}</td>
                            <td class="text-center">
                                <a href="{{$data->avatar }}" target="_blank">
                                    <img class="rounded-circle header-profile-user" src="{{$data->avatar}}" />
                                </a>
                            </td>
                            <td class="text-center ">{{ $data->role->name }}</td>
                            <td class="text-center ">{{ $data->region?->dkr_name }}, {{ $data->region?->dkc_name }}</td>
                            <td class="text-center">
                                <button onclick="editModal({{ json_encode($data->id) }})" type="button" class="btn btn-warning btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $data->id }}" ><i class=" bx bx-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $data->id }}"><i class=" bx bx-trash"></i> Delete</button>
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
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-user.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" id="validationCustom02" value="{{ old('name') }}" placeholder="Nama" required>
                                <div class="valid-feedback">
                                    Nama Harus Diisi!
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Fullname</label>
                                <input name="fullname" type="text" class="form-control" id="validationCustom02" value="{{ old('fullname') }}" placeholder="Nama Lengkap" required>
                                <div class="valid-feedback">
                                    Fullname Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="validationCustom02" value="{{ old('email') }}" placeholder="Email" required>
                                <div class="valid-feedback">
                                    Email Harus Diisi!
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                </div>
                                <div class="valid-feedback">
                                    Password Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Password Confirmation</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password confirmation" aria-label="Password" aria-describedby="password-confirmation-addon">
                                    <button class="btn btn-light " type="button" id="password-confirmation-addon"><i class="mdi mdi-eye-outline"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Role User</label>
                                <select name="role_id" class="form-select">
                                    <option disabled selected>---Pilih Role User ---</option>
                                    @foreach ($role as $item)
                                    <option value="{{ $item->id }}" @selected(old('role_id')==$item->id)>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Role Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir</label>
                                <div class="input-group">
                                    <input name="pob" type="text" class="form-control" id="validationCustom02" value="{{ old('pob') }}" required placeholder="Tempat Lahir">
                                    <input name="dob" type="date" class="form-control" id="validationCustom02" value="{{ date('Y-m-d', strtotime(old('dob'))) }}" required>
                                    <div class="valid-feedback">
                                        Tempat Tanggal Lahir Harus Diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Region</label>
                                <select class="form-select select2" name="region_id" id="mySelect2">
                                    <option disabled selected>---Pilih Region User ---</option>
                                    @foreach ($region as $item)
                                    <option value="{{ $item->id }}" @selected(old('region_id')==$item->id)>{{ $item->dkc_name }}, {{ $item->dkr_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Photo</label>
                                <input name="avatar" type="file" class="form-control" id="validationCustom02">
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

<!-- Start Edit Modal -->
@foreach ($user as $data)
<div class="modal fade" id="modal-edit-{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-user.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" id="validationCustom02" value="{{ $data->name }}" placeholder="Nama" required>
                                <div class="valid-feedback">
                                    Nama Harus Diisi!
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Fullname</label>
                                <input name="fullname" type="text" class="form-control" id="validationCustom02" value="{{ $data->fullname }}" placeholder="Nama Lengkap" required>
                                <div class="valid-feedback">
                                    Fullname Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="validationCustom02" value="{{ $data->email }}" placeholder="Email" required>
                                <div class="valid-feedback">
                                    Email Harus Diisi!
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Role User</label>
                                <select name="role_id" class="form-control" id="validationCustom02">
                                    <option disabled selected>---Pilih Role User ---</option>
                                    @foreach ($role as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $data->role_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Role Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir</label>
                                <div class="input-group">
                                    <input name="pob" type="text" class="form-control" id="validationCustom02" value="{{ $data->pob }}">
                                    <input name="dob" type="date" class="form-control" id="validationCustom02" value="{{ date('Y-m-d', strtotime($data->dob)) }}">
                                    <div class="valid-feedback">
                                        Tempat Tanggal Lahir Harus Diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Region</label>
                                <select name="region_id" class="form-select select2" id="editSelect2{{ $data->id }}">
                                    <option disabled selected>---Pilih Region User ---</option>
                                    @foreach ($region as $item)
                                    <option value="{{ $item->id }}" @selected($data->region_id == $item->id )>{{ $item->dkc_name }}, {{ $item->dkr_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Photo</label>
                                <input name="avatar" type="file" class="form-control" id="validationCustom02">
                            </div>
                        </div>
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
<!-- End Edit Modal -->

<!-- Start Delete Modal -->
<div class="modal fade" id="modal-delete-{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-user.destroy', $data->id) }}" method="POST">
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
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
<script>
    $('#mySelect2').select2({
        dropdownParent: $('#modal-add'),
        width: '100%'
    });
</script>
<script>
    function editModal(id){
        let id_modal = id;
        $('#editSelect2' + id_modal).select2({
            dropdownParent: $('#modal-edit-'+id_modal ),
            width: '100%'
         });
    }
</script>

@endsection
