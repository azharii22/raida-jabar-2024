@extends('layouts.master')

@section('title', 'Region')

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
            Region
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-5">Region</h4>

                    <div class="card-title mb-5">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2"
                            data-bs-toggle="modal" data-bs-target="#modal-add" id="addButton"> <i class="bx bx-plus"></i>
                            Add Region</button>
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

                    <table id="region" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">DKC Name</th>
                                <th class="text-center">DKR Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <!-- Start modal add -->
    <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-addLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-addLabel">Add New Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add_regency">Regency</label>
                            <select class="form-select" id="add_regency" name="regency_id" required>
                                <!-- Options will be loaded dynamically -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_name">Name</label>
                            <input type="text" class="form-control" id="add_name" name="name" required>
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
    <!-- End modal add -->
    <!-- Start modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Form fields here -->
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_regency">Regency</label>
                            <select id="edit_regency" name="regency_id" class="form-select" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <input type="hidden" id="delete_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#region').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin-region.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                        return '<div class="text-center">' + data + '</div>';
                    }
                    },
                    {
                        data: 'regency_name',
                        name: 'regency_name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#addButton').click(function() {
                $.get('/selectRegency', function(data) {
                    var regencySelect = $('#add_regency');
                    regencySelect.empty();
                    if (data && data.length > 0) {
                        $.each(data, function(index, regency) {
                            regencySelect.append('<option value="' + regency.id + '">' +
                                regency.name + '</option>');
                        });
                    } else {
                        regencySelect.append('<option value="">No regencies available</option>');
                    }
                    $('#modal-add').modal('show');
                }).fail(function() {
                    alert('Failed to load regencies');
                });
            });

            // Submit add form
            $('#addForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/storeRegency',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        $('#modal-add').modal('hide');
                        table.ajax.reload();

                        // Reset the form fields
                        $('#addForm')[0].reset();
                        $('#add_regency').val(null).trigger('change');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to add data');
                    }
                });
            });

            // Edit button click
            $('#region').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get('/regency/' + id + '/edit', function(response) {
                    var data = response.data;
                    var regencies = response.regencies;

                    // Populate form fields
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);

                    // Populate regency select options
                    var select = $('#edit_regency');
                    select.empty();
                    $.each(regencies, function(index, regency) {
                        var selected = (data.regency_id == regency.id) ? 'selected' : '';
                        select.append('<option value="' + regency.id + '" ' + selected +
                            '>' + regency.name + '</option>');
                    });

                    $('#editModal').modal('show');
                });
            });

            // Delete button click
            $('#region').on('click', '.delete', function() {
                var id = $(this).data('id');
                $('#delete_id').val(id);
                $('#deleteModal').modal('show');
            });

            // Submit edit form
            $('#editForm').submit(function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                $.ajax({
                    url: '/regency/' + id,
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(data) {
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                    }
                });
            });

            // Submit delete form
            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                var id = $('#delete_id').val();
                $.ajax({
                    url: '/regency/' + id,
                    type: 'DELETE',
                    data: $(this).serialize(),
                    success: function(data) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                    }
                });
            });
        });
    </script>
@endsection
