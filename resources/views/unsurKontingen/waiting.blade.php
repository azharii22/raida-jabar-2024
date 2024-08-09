@extends('layouts.master')

@section('title', 'Unsur Kontingen')

@section('content')

    <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">Processing PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your PDF is being processed. Please wait...</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the modal
        var progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();

        // Polling to update progress
        function checkProgress() {
            fetch('/pdf-progress')
                .then(response => response.json())
                .then(data => {
                    if (data.progress < 100) {
                        document.querySelector('.progress-bar').style.width = data.progress + '%';
                        document.querySelector('.progress-bar').setAttribute('aria-valuenow', data.progress);
                        setTimeout(checkProgress, 1000); // Check every second
                    } else {
                        document.querySelector('.progress-bar').style.width = '100%';
                        document.querySelector('.progress-bar').setAttribute('aria-valuenow', '100');
                        // Optionally close modal or redirect to download
                        setTimeout(() => {
                            progressModal.hide();
                            window.location.href = data.downloadUrl;
                        }, 1000); // Wait a moment before redirecting
                    }
                });
        }

        checkProgress();
    </script>
@endsection
