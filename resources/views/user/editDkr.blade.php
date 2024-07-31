@extends('layouts.master')

@section('title', 'User')

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/datepicker/datepicker.min.css') }}">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('title') User @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-5">Edit User Management</h4>

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

                    <form action="{{ route('admin-user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control" id="validationCustom02" value="{{ $user->name }}" placeholder="Nama" required>
                                    <div class="valid-feedback">
                                        Nama Harus Diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Fullname</label>
                                    <input name="fullname" type="text" class="form-control" id="validationCustom02" value="{{ $user->fullname }}" placeholder="Nama Lengkap" required>
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
                                    <input name="email" type="email" class="form-control" id="validationCustom02" value="{{ $user->email }}" placeholder="Email" required>
                                    <div class="valid-feedback">
                                        Email Harus Diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input name="pob" type="text" class="form-control" id="validationCustom02" value="{{ $user->pob }}" required placeholder="Tempat Lahir">
                                        <input name="dob" type="date" class="form-control" id="validationCustom02" value="{{ date('Y-m-d', strtotime($user->dob)) }}" required>
                                        <div class="valid-feedback">
                                            Tempat Tanggal Lahir Harus Diisi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Regency</label>
                                    <select class="form-select" name="regency_id" id="selectRegency"></select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Villages</label>
                                    <select class="form-select" name="villages_id" id="selectVillages"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Photo</label>
                                    <input name="avatar" type="file" class="form-control" id="validationCustom02">
                                    <input name="role_id" value="{{ $role->id }}" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <a href="{{ route('admin-user.index') }}" class="btn btn-secondary waves-effect">Back</a>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- end select2 -->

        </div>


    </div>
    <!-- end row -->

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

    <!-- form advanced init -->
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#selectRegency").select2({
                placeholder: "Select Regency",
                ajax: {
                    url: '/selectRegencyUser',
                    processResults: function({data}){
                        return {
                            results: $.map(data, function(item){
                                return {
                                    id: item.id,
                                    text: item.name,
                                }
                            })
                        }
                    }
                }
            });
            $("#selectRegency").change(function(){
                let id = $('#selectRegency').val();

                $("#selectVillages").select2({
                    placeholder:'Select Villages',
                    ajax: {
                        url: "{{url('selectVillages')}}-"+ id,
                        processResults: function({data}){
                            return {
                                results: $.map(data, function(item){
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });
        });
        var selectedRegencyId = `{{ $user->regency?->id }}`;
        var selectedVillagesId = `{{ $user->villages?->id }}`;
        var selectedUserRegency = "{{ $user->regency?->name }}";
        var selectedUserVillages = "{{ $user->villages?->name }}";

        var option1 = new Option(selectedUserRegency, selectedRegencyId, true, true);
        $('#selectRegency').append(option1).trigger('change');
        var option2 = new Option(selectedUserVillages, selectedVillagesId, true, true);
        $('#selectVillages').append(option2).trigger('change');

    </script>
@endsection
