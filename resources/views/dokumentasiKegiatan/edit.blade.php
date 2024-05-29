@extends('peransaka.layout.master')

@section('title', 'Dokumentasi')

@section('css')
<!-- Plugins css -->
<link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Dokumentasi @endslot
@slot('title') Dokumentasi Upload @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dokumentasi.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="formrow-judul-input" class="form-label">Judul</label>
                        <input name="judul" type="text" class="form-control" id="formrow-judul-input" placeholder="Judul Artikel" value="{{ $dokumentasi->judul }}">
                    </div>

                    <div class="mb-3">
                        <label for="formrow-cover-input" class="form-label">Cover</label>
                        <input name="cover" type="file" class="form-control" id="formrow-cover-input" placeholder="Deskripsi Artikel" value="{{ $dokumentasi->cover }}">
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<!-- Plugins js -->
<script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
@endsection