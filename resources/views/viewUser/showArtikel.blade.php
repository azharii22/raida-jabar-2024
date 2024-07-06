@extends('viewUser.layouts.master')

@section('title', 'Artikel')

@section('content')

    <!-- Blog Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-8">
                    <!-- Blog Detail Start -->
                    <div class="mb-5">
                        <img class="img-fluid w-100 rounded mb-5"
                            src="{{ Storage::url('public/img/artikel/') . $artikel->foto }}" alt="">
                        <h1 class="mb-4 text-capitalize">{{ $artikel->judul }}</h1>
                        <p>{!! $artikel->isi_artikel !!}</p>
                    </div>
                    <!-- Blog Detail End -->

                    <!-- Comment List Start -->
                    <div class="mb-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">{{ count($comment) }} Comments</h3>
                        </div>
                        @foreach ($comment as $data)
                            <div class="d-flex mb-4">
                                <div class="ps-3">
                                    <h6><a href="">{{ $data->nama }}</a>
                                        <small><i>{{ date('d M Y', strtotime($data->created_at)) }}</i></small></h6>
                                    <div class="col">
                                        <div class="rated">
                                            @for ($i = 1; $i <= $data->star_rating; $i++)
                                                <input type="radio" id="star{{ $i }}" class="rate"
                                                    name="rating" value="5" />
                                                <label class="star-rating-complete" title="text">{{ $i }}
                                                    stars</label>
                                            @endfor
                                        </div>
                                    </div>
                                    <p>{{ $data->comments }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Comment List End -->
                    @if (!empty($value->star_rating))
                        <div class="container">
                            <div class="row">
                                <div class="col mt-4">
                                    <p class="font-weight-bold ">Review</p>
                                    <div class="form-group row">
                                        <div class="col">
                                            <div class="rated">
                                                @for ($i = 1; $i <= $value->star_rating; $i++)
                                                    {{-- <input type="radio" id="star{{$i}}" class="rate" name="rating" value="5"/> --}}
                                                    <label class="star-rating-complete" title="text">{{ $i }}
                                                        stars</label>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col">
                                            <p>{{ $value->comments }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="container">
                            <div class="row">
                                <div class="col mt-4">
                                    <form class="py-2 px-4" action="{{ route('reviewArtikel.store', $artikel->slug) }}"
                                        style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                            <h3 class="mb-0">Leave A Review</h3>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col">
                                                <div class="rate">
                                                    <input type="radio" id="star5" class="rate" name="rating"
                                                        value="5" />
                                                    <label for="star5" title="text">5 stars</label>
                                                    <input type="radio" checked id="star4" class="rate"
                                                        name="rating" value="4" />
                                                    <label for="star4" title="text">4 stars</label>
                                                    <input type="radio" id="star3" class="rate" name="rating"
                                                        value="3" />
                                                    <label for="star3" title="text">3 stars</label>
                                                    <input type="radio" id="star2" class="rate" name="rating"
                                                        value="2">
                                                    <label for="star2" title="text">2 stars</label>
                                                    <input type="radio" id="star1" class="rate" name="rating"
                                                        value="1" />
                                                    <label for="star1" title="text">1 star</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-4">
                                            <div class="col">
                                                <input name="nama" type="text" class="form-control bg-white "
                                                    placeholder="Your Name" style="height: 55px;" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-4">
                                            <div class="col">
                                                <textarea class="form-control" name="comment" rows="6 " placeholder="Comment" maxlength="200" required></textarea>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 py-3" type="submit">Leave Your
                                                Review</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Comment Form End -->
                </div>

                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Recent Post Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">5 Recent Post</h3>
                        </div>
                        @foreach ($artikelDesc as $data)
                            <div class="d-flex rounded overflow-hidden mb-3">
                                <img class="img-fluid"
                                    src="{{ isset($data->foto) ? Storage::url('public/img/artikel/') . $data->foto : asset('/assets/images/no-image.png') }}"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                <a href="{{ route('viewUser.show-artikel', $data->slug) }}"
                                    class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">{{ $data->judul }}</a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Recent Post End -->
                    <hr />
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Blog End -->

@endsection

@section('script')
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .star-rating-complete {
            color: #c59b08;
        }

        .rating-container .form-control:hover,
        .rating-container .form-control:focus {
            background: #fff;
            border: 1px solid #ced4da;
        }

        .rating-container textarea:focus,
        .rating-container input:focus {
            color: #000;
        }

        .rated {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rated:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ffc700;
        }

        .rated:not(:checked)>label:before {
            content: '★ ';
        }

        .rated>input:checked~label {
            color: #ffc700;
        }

        .rated:not(:checked)>label:hover,
        .rated:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rated>input:checked+label:hover,
        .rated>input:checked+label:hover~label,
        .rated>input:checked~label:hover,
        .rated>input:checked~label:hover~label,
        .rated>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
@endsection
