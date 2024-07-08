@extends('layouts.master')

@section('title', 'Tentang')

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Tentang
        @endslot
        @slot('title')
            Create Tentang
        @endslot
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

                    @if ($tentang == NULL)    
                    <form action="{{ route('admin-tentang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Foto Tentang</label>
                            <input name="foto" class="form-control" type="file">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Tentang</label>
                            <textarea id="elm1" name="name">{{ old('name') }}</textarea>
                        </div>
                        <div>
                            <a href="{{ route('admin-tentang.index') }}" type="button"
                                class="btn btn-secondary w-md m-2 align-self-end">Cancel</a>
                            <button type="submit" class="btn btn-primary w-md m-2 align-self-end">Submit</button>
                        </div>
                    </form>
                    @else
                    <form action="{{ route('admin-tentang.update', $tentang->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Foto Tentang Sebelumnya</label> <br />
                            <img src="{{ Storage::url('viewUser/img/tentang/'.$tentang->foto) }}" width="100px"
                            height="100px" alt="Foto Tentang" class="img-thumbnail">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Update Foto Tentang</label>
                            <input name="foto" class="form-control" type="file">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Tentang</label>
                            <textarea id="elm1" name="name">{{ $tentang->name }}</textarea>
                        </div>
                        <div>
                            <a href="{{ route('admin-tentang.index') }}" type="button"
                                class="btn btn-secondary w-md m-2 align-self-end">Cancel</a>
                            <button type="submit" class="btn btn-primary w-md m-2 align-self-end">Update</button>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <!--tinymce js-->
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection
