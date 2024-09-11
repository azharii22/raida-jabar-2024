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
                    <h4 class="card-title mb-5">Dengan jumlah : {{ $peserta }} Peserta</h4>
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
                        <button id="startExport" class="btn btn-danger waves-effect waves-light btn-sm mr-2">
                            <i class="mdi mdi-file-pdf-outline"></i> Export PDF
                        </button>
                        <a href="{{ route('idCard') }}" type="button"
                            class="btn btn-primary waves-effect waves-light btn-sm mr-2" target="_blank"> <i
                                class="bx bx bx-id-card"></i> Export Id Card</a>

                        <!-- Modal -->
                        <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel"
                            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="progressModalLabel">Processing PDF</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Your PDF is being processed. Please wait...</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div id="progressText">Progress: 0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                ajax: '{{ route('data.getRegenciesPeserta') }}',
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
    <script type="text/javascript">
        document.getElementById('startExport').addEventListener('click', function() {
            var progressModalElement = document.getElementById('progressModal');
            var progressModal = new bootstrap.Modal(progressModalElement, {
                backdrop: 'static',
                keyboard: false
            });
            progressModal.show();

            // Trigger the job
            fetch('{{ route('peserta.pdf') }}')
                .then(response => response.json())
                .then(data => {
                    // Start checking progress after the job is triggered
                    checkProgress();
                })
                .catch(error => console.log('Error triggering job:', error));
        });

        function updateProgressBar(progress) {
            let progressBar = document.querySelector('.progress-bar');
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            document.getElementById('progressText').innerText = 'Progress: ' + progress + '%';
        }

        function checkProgress() {
            fetch('{{ url('/export-pdf-status-peserta') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.progress < 100) {
                        updateProgressBar(data.progress);
                        setTimeout(checkProgress, 5000); // Check every second (1 Detik)
                    } else {
                        updateProgressBar(100);
                        setTimeout(() => {
                            var progressModalElement = document.getElementById('progressModal');
                            var progressModal = bootstrap.Modal.getInstance(progressModalElement);
                            progressModal.hide();

                            setTimeout(() => {
                                if (data.downloadUrl) {
                                    window.open(data.downloadUrl, '_blank'); // Open download in new tab
                                } else {
                                    console.log('Download URL is null');
                                    alert(
                                        'File tidak tersedia untuk diunduh. Silakan coba lagi nanti.'
                                    );
                                }
                            }, 500);
                        }, 1000);
                    }
                })
                .catch(error => console.log('Error checking progress:', error));
        }
    </script>
@endsection
