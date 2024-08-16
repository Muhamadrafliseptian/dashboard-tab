@extends('pages.layouts.main')

@section('title', 'Administrator')

@section("component-css")
<link href="{{ url('public/template') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="{{ url('public/template') }}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="{{ url('public/template') }}/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="{{ url('public/template') }}/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
@endsection

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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Data @yield('title')
                        </h2>
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                            data-target=".bs-example-modal-lg">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th class="text-center">Kode Akun Member</th>
                                    <th class="text-center">Nama Paket</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Kode Negara</th>
                                    <th class="text-center">Nomor HP</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($accountAdmin as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td>{{ $item["nama"] }}</td>
                                    <td class="text-center">{{ $item["member_account_code"] }}</td>
                                    <td class="text-center">{{ empty($item["paketOrganization"]["nama_paket"]) ? "-" : $item["paketOrganization"]["nama_paket"] }}</td>
                                    <td class="text-center">{{ $item["username"] }}</td>
                                    <td class="text-center">{{ $item["country_code"] }}</td>
                                    <td class="text-center">{{ $item["phone_number"] }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pages.accounts.admin.show', ['id' => $item['id_master_organization']]) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        <i class="fa fa-plus"></i> Tambah Data
                    </h4>
                </div>
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
                        <div class="form-group">
                            <label for="password" class="form-label"> Master Paket </label>
                            <select name="id_master_paket_organization" class="form-control"
                                id="id_master_paket_organization">
                                <option value="">- Pilih -</option>
                                @foreach ($masterPaket as $item)
                                    <option value="{{ $item['detail']['id_master_paket_organization'] }}">
                                        {{ $item['detail']['nama_paket'] }} - Limit Responder :
                                        {{ $item['detail']['limitContact'] }} - Rp.
                                        {{ number_format($item['detail']['amount']) }}
                                    </option>
                                @endforeach
                            </select>
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
            </div>
        </div>
    </div>

@endsection

@section("component-js")
<script src="{{ url('public/template') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
@endsection
