<form action="{{ route('admin-kegiatan.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Judul</label>
            <input name="judul" type="text" class="form-control" id="validationCustom02" value="{{ $data->judul }}" required>
        </div>
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Item Giat</label>
            <input name="item_giat" type="text" class="form-control" id="validationCustom02" value="{{ $data->item_giat }}" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
    </div>
</form>