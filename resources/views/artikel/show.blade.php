@extends('layouts.master')

@section('title', 'Read Artikel')

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Artikel @endslot
@slot('title2') Read Artikel @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="pt-3">
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <a href="#" class="badge bg-light font-size-12">
                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> Project
                                        </a>
                                    </div>
                                    <h4>{{ $artikel->judul }}</h4>
                                    <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i> {{ date('d-M-Y', strtotime($artikel->created_at)) }}</p>
                                </div>

                                <hr>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div>
                                                <p class="text-muted mb-2">Categories</p>
                                                <h5 class="font-size-15">Project</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Date</p>
                                                <h5 class="font-size-15">{{ date('d-M-Y', strtotime($artikel->created_at)) }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Post by</p>
                                                <h5 class="font-size-15">{{ $artikel->user->name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="my-5">
                                    <img src="{{ Storage::url('public/img/artikel/').$artikel->foto }}" alt="" class="img-thumbnail mx-auto d-block" width="300px" height="300px">
                                </div>

                                <hr>

                                <div class="mt-4">
                                    <div class="text-muted font-size-14">
                                        <p>{!! $artikel->isi_artikel !!}</p>

                                    </div>

                                    <hr>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection