@extends('layouts.master')

@section('title', 'Peserta')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Peserta
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-5">Peserta</h4>
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

                    <div class="card-title mb-5">
                        <a href="{{ route('peserta.excel') }}" type="button"
                            class="btn btn-success waves-effect waves-light btn-sm mr-2" target="_blank"> <i
                                class="mdi mdi-file-excel-outline"></i> Export Excel</a>
                        <a href="{{ route('peserta.pdf') }}" type="button"
                            class="btn btn-danger waves-effect waves-light btn-sm mr-2" target="_blank"> <i
                                class="mdi mdi-file-pdf-outline"></i> Export PDF</a>
                    </div>

                    <div class="table-responsive">
                        <table id="regenciesTable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kwarcab</th>
                                    <th>Jumlah Pendaftar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#regenciesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data.getRegencies') }}',
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
                        name: 'name'
                    },
                    {
                        data: 'jumlah_pendaftar',
                        name: 'jumlah_pendaftar'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
