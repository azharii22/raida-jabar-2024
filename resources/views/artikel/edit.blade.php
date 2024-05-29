@extends('layouts.master')

@section('title', 'Edit Artikel')

@section('content')

@component('components.breadcrumb')
@slot('li_1') Artikel @endslot
@slot('title') Edit Artikel @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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

                <form action="{{ route('admin-artikel.update', $artikel->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="formrow-judul-input" class="form-label">Judul</label>
                        <input name="judul" type="text" class="form-control" id="formrow-judul-input" placeholder="Judul Artikel" value="{{ $artikel->judul }}">
                    </div>

                    <div class="mb-3">
                        <label for="formrow-deskripsi-input" class="form-label">Deskripsi</label>
                        <input name="deskripsi" type="text" class="form-control" id="formrow-deskripsi-input" placeholder="Deskripsi Artikel" value="{{ $artikel->deskripsi }}">
                    </div>

                    <div class="mb-3">
                        <label for="formrow-foto-input" class="form-label">Foto</label>
                        <input name="foto" type="file" class="form-control" id="formrow-foto-input">
                        <img class="mt-5 mb-5" src="{{ isset($artikel->foto) ? asset(Storage::url('public/img/artikel/').$artikel->foto) : asset('/assets/images/users/avatar-icon.webp') }}" id="formrow-foto-input" width="150px" height="150px" alt="">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Artikel</label>
                        <textarea id="elm1" name="isi_artikel">{{ $artikel->isi_artikel }}</textarea>
                    </div>
                    <div>
                        <a href="{{ route('admin-artikel.index') }}" type="button" class="btn btn-secondary w-md m-2 align-self-end">Cancel</a>
                        <button type="submit" class="btn btn-primary w-md m-2 align-self-end">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
@section('script')
<!--tinymce js-->
<script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

<!-- init js -->
<script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection