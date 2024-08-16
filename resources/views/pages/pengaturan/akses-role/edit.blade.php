<form action="{{ route('pages.pengaturan.role.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="role_name" class="form-label"> Nama Akses Role </label>
            <input type="text" class="form-control" name="role_name" id="role_name"
                placeholder="Masukkan Nama" value="{{ old('role_name') }}">
        </div>
        <div class="form-group">
            <label for="level_role" class="form-label"> Level </label>
            <input type="number" class="form-control" name="level_role" id="level_role" placeholder="0"
                min="1" value="{{ old('level_role') }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-danger">
            <i class="fa fa-times"></i> Batal
        </button>
        <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</form>
