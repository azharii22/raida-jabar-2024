<form action="{{ route('admin-settings.update',$data->id) }}" method="post" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Value</label>
            <input type="text" class="form-control" id="validationCustom02" value="{{ $data->value }}" name="value" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>