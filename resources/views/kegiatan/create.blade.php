@extends('layouts.master')

@section('title', 'Create Kegiatan')

@section('content')

@component('components.breadcrumb')
@slot('li_1') Kegiatan @endslot
@slot('title') Create Kegiatan @endslot
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
                
                <form action="{{ route('admin-kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formrow-judul-input" class="form-label">Judul</label>
                        <input name="judul" type="text" class="form-control" id="formrow-judul-input" placeholder="Judul Kegiatan" value="{{ old('judul') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Kegiatan</label>
                        <textarea id="elm1" name="item_giat">{{ old('item_giat') }}</textarea>
                    </div>
                    <div>
                        <a href="{{ route('admin-kegiatan.index') }}" type="button" class="btn btn-secondary w-md m-2 align-self-end">Cancel</a>
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