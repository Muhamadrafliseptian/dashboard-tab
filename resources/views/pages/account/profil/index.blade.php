@extends('pages.layouts.main')

@section('title', 'Profil Saya')

@section('content-page')

    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    @yield('title')
                </h3>
            </div>
        </div>

        <div class="clearfix"></div>

        @if (session('success'))
            <div class="alert alert-success text-uppercase">
                <strong>Berhasil</strong>, {!! session('success') !!}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger text-uppercase">
                <strong>Gagal</strong>, {!! session('error') !!}
            </div>
        @endif

        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Data @yield('title')
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form
                            action="{{ route('pages.account.profil.update', ['member_account_code' => session('data.member_account_code')]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama" class="form-label"> Nama Organisasi</label>
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Masukkan Nama" value="{{ old('nama', $detail['nama']) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama" class="form-label"> Nama PIC</label>
                                        <input type="text" class="form-control" name="nama_pic" id="nama_pic"
                                            placeholder="Masukkan Nama PIC"
                                            value="{{ old('nama_pic', $detail['nama_pic']) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username" class="form-label"> Username </label>
                                        <input type="username" class="form-control" name="username" id="username"
                                            placeholder="Masukkan Username"
                                            value="{{ old('username', $detail['username']) }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="form-label"> Nomor Telepon PIC </label>
                                        <input type="username" class="form-control" name="phone_number_pic"
                                            id="phone_number_pic" placeholder="Masukkan Nomor Telepon PIC"
                                            value="{{ old('phone_number_pic', $detail['phone_number_pic']) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            @if (session('data')['account_category'] === 'INTERNAL')
                                <div class="form-group">
                                    <label for="nama" class="form-label"> Kategori Organisasi/Usaha</label>
                                    <input type="text" class="form-control" disabled name="alamat_organisasi"
                                        id="alamat_organisasi" placeholder="Masukkan Nama"
                                        value="{{ old('alamat_organisasi', $detail['detailMembership']['bisnis_category']) }}">
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        @if (session('data')['account_category'] === 'PARTNER')
                                            <label for="member_account_code" class="form-label"> Kode Institusi </label>
                                            <input type="number" class="form-control" name="member_account_code"
                                                id="member_account_code" placeholder="Masukkan Kode Member Akun"
                                                min="1"
                                                value="{{ old('unique_institution_id', $detail['unique_institution_id']) }}"
                                                readonly>
                                        @else
                                        <label for="member_account_code" class="form-label"> Kode Institusi </label>
                                            <input type="number" class="form-control" name="member_account_code"
                                                id="member_account_code" placeholder="Masukkan Kode Member Akun"
                                                min="1"
                                                value="{{ old('unique_institution_id', $detail['institution_id']) }}"
                                                readonly>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="nama" class="form-label"> Nomor Telepon Organisasi</label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number"
                                            readonly placeholder="Masukkan Nama"
                                            value="{{ old('phone_number', $detail['phone_number']) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="form-label"> Alamat Organisasi</label>
                                <input type="text" class="form-control" name="alamat_organisasi" id="alamat_organisasi"
                                    placeholder="Masukkan Nama"
                                    value="{{ old('alamat_organisasi', $detail['alamat_organisasi']) }}">
                            </div>
                            <hr>
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <i class="fa fa-edit"></i> Ganti Password
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form
                            action="{{ route('pages.account.profil.change-password', ['member_acccount_code' => session('data.username')]) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="old_password" class="form-label"> Password Lama </label>
                                <input type="password" class="form-control" name="old_password" id="old_password"
                                    placeholder="Masukkan Password Lama">
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="form-label"> Password Baru </label>
                                <input type="password" class="form-control" name="new_password" id="new_password"
                                    placeholder="Masukkan Password Baru">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="form-label"> Konfirmasi Password </label>
                                <input type="password" class="form-control" name="confirm_password"
                                    id="confirm_password" placeholder="Masukkan Konfirmasi Password">
                            </div>
                            <hr>
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
