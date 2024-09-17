@extends('viewUser.layouts.master')

@section('title', 'Photo Dokumentasi')

@section('content')

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">{{ $photo->total() }} Dokumentasi </h5>
            </div>
            <div class="row g-5" id="photo-container">
                @foreach ($photo as $data)
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div
                            class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="mb-5">
                                <img class="img-fluid" src="{{ url('uploads/gallery/', $data->filename) }}"
                                    style="height: 200px; text-align: center;" alt="">
                            </div>
                            <a class="btn2 btn-lg btn-primary rounded"
                                href="{{ route('viewUserDownloadPhoto', $data->id) }}" target="_blank">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="scroll-loader" style="text-align: center;">
                <p>Loading more photos...</p>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var page = 1;
        var lastPage = {{ $photo->lastPage() }};
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                page++;
                if (page <= lastPage) {
                    loadMorePhotos(page);
                }
            }
        });

        function loadMorePhotos(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: 'get',
                    beforeSend: function() {
                        $('#scroll-loader').show();
                    }
                })
                .done(function(data) {
                    if (data.html == "") {
                        $('#scroll-loader').html("No more photos");
                        return;
                    }
                    $('#scroll-loader').hide();
                    $('#photo-container').append(data.html);
                })
                .fail(function(xhr, status, error) {
                    alert('Failed to load photos.');
                });
        }
    </script>
@endsection
