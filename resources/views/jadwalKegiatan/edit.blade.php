<form action="{{ route('admin-jadwal-kegiatan.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Tanggal Kegiatan</label>
            <input name="tanggal_giat" type="date" class="form-control" id="validationCustom02" value="{{ $data->tanggal_giat }}" required>
        </div>
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">File</label>
            <input name="file" type="file" class="form-control" id="validationCustom02" required accept=".pdf">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
    </div>
</form>