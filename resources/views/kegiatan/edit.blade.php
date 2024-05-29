<form action="{{ route('admin-user.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="validationCustom02" value="{{ $data->name }}" placeholder="Nama" required>
                    <div class="valid-feedback">
                        Nama Harus Diisi!
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Fullname</label>
                    <input name="fullname" type="text" class="form-control" id="validationCustom02" value="{{ $data->fullname }}" placeholder="Nama Lengkap" required>
                    <div class="valid-feedback">
                        Fullname Harus Diisi!
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="validationCustom02" value="{{ $data->email }}" placeholder="Email" required>
                    <div class="valid-feedback">
                        Email Harus Diisi!
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Role User</label>
                    <select name="role_id" class="form-control" id="validationCustom02">
                        <option disabled selected>---Pilih Role User ---</option>
                        @foreach ($role as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $data->role_id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div class="valid-feedback">
                        Role Harus Diisi!
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir</label>
                    <div class="input-group">
                        <input name="pob" type="text" class="form-control" id="validationCustom02" value="{{ $data->pob }}">
                        <input name="dob" type="date" class="form-control" id="validationCustom02" value="{{ date('Y-m-d', strtotime($data->dob)) }}">
                        <div class="valid-feedback">
                            Tempat Tanggal Lahir Harus Diisi!
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Photo</label>
                    <input name="avatar" type="file" class="form-control" id="validationCustom02">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
    </div>
</form>