@foreach ($photo as $data)
    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
        <div
            class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
            <div class="mb-5">
                <img class="img-fluid" src="{{ url('uploads/gallery/', $data->filename) }}"
                    style="height: 200px; text-align: center;" alt="">
            </div>
            <a class="btn2 btn-lg btn-primary rounded" href="{{ route('viewUserDownloadPhoto', $data->id) }}"
                target="_blank">
                <i class="bi bi-download"></i>
            </a>
        </div>
    </div>
@endforeach
