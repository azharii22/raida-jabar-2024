@extends('layouts.master')

@section('title', 'User')

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-5">User Management</h4>

                    <div class="card-title mb-5">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-sm mr-2"
                                data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-plus"></i> Add User
                            </button>
                            <div class="dropdown-menu">
                                <div class="p-3">
                                    <p class="mb-0">
                                        Pilih Salah Satu User Di Bawah ini!
                                    </p>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('createDkd') }}"><i class="bx bx-plus"></i> Add User
                                    DKD</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('createDkc') }}"><i class="bx bx-plus"></i> Add User
                                    DKC</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('createDkr') }}"><i class="bx bx-plus"></i> Add User
                                    DKR</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>
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

                    <table id="userData" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Fullname</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Region</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <input type="hidden" id="delete_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->

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
        function editModal(id) {
            let id_modal = id;
            $('#editSelect2' + id_modal).select2({
                dropdownParent: $('#modal-edit-' + id_modal),
                width: '100%'
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#userData').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataUser.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return '<div class="text-center">' + data + '</div>';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center'
                    },
                    {
                        data: 'fullname',
                        name: 'fullname',
                        className: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-center'
                    },
                    {
                        data: 'role.name',
                        name: 'role.name',
                        className: 'text-center'
                    },
                    {
                        data: 'region_name',
                        name: 'region_name',
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            // Delete button click
            $('#userData').on('click', '.delete', function() {
                var id = $(this).data('id');
                $('#delete_id').val(id);
                $('#deleteModal').modal('show');
            });

            // Submit delete form
            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                var id = $('#delete_id').val();
                $.ajax({
                    url: '/admin-user/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteModal').modal('hide');
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data deleted successfully',
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection
