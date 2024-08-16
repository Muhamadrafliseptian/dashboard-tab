<form action="{{ route('pages.accounts.admin.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="nama" class="form-label"> Nama </label>
            <input type="text" class="form-control" name="nama" id="nama"
                placeholder="Masukkan Nama" value="{{ old('nama') }}">
        </div>
        <div class="form-group">
            <label for="phone_number" class="form-label"> Nomor HP </label>
            <input type="number" class="form-control" name="phone_number" id="phone_number"
                placeholder="Masukkan Nomor HP" value="{{ old('phone_number') }}">
        </div>
        <div class="form-group">
            <label for="password" class="form-label"> Password </label>
            <input type="password" class="form-control" name="password" id="password"
                placeholder="Masukkan Password">
        </div>
        <div class="form-group">
            <label for="country_code" class="form-label"> Kode Negara </label>
            <input type="text" class="form-control" name="country_code" id="country_code"
                placeholder="Masukkan Kode Negara">
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
