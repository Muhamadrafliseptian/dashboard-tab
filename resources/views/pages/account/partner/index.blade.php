@extends('pages.layouts.main')

@section('title', '' . $dataname)

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
                                    <th class="text-center">Nomor HP</th>
                                    <th class="text-center">Kode Institusi</th>
                                    <th class="text-center">Tanggal Dibuat</th>
                                    <th class="text-center">Total Responder</th>
                                    <th class="text-center">Total Transaksi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($response as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td>{{ $item["nama"] }}</td>
                                    <td class="text-center">{{ $item['phone_number'] }}</td>
                                    <td class="text-center">{{ $item["unique_institution_id"] }}</td>
                                    <td class="text-center">{{ $item["created_at"] }}</td>
                                    <td class="text-center">{{ $item['total_responder'] }}</td>
                                    <td class="text-center">{{ $item['total_transaksi'] }}</td>
                                    <td class="text-center">
                                        @if ($item['total_responder'] != 0)
                                        <a href="{{ route('pages.account.partner.lihat-responder', ['name' => $dataname, 'institution_id' => $item['institution_id']]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-search"></i> Lihat Responder
                                        </a>
                                        @endif
                                        @if ($item['total_transaksi'] != 0)

                                        <a href="{{ route('pages.account.partner.lihat-transaksi', ['name' => $dataname, 'institution_id' => $item['institution_id']]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-search"></i> Lihat Transaksi
                                        </a>
                                        @endif

                                        @if ($dataname == "KODIM")
                                        <a href="{{ route('pages.account.partner.lihat-kodim', ['name' => session("data")["sub_category_organization_id"]["name"], 'province_id' => $item['province_id'], "regency_id" => $item['regency_id']]) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                        @else
                                        <a href="{{ route('pages.account.partner.lihat-polsek', ['name' => session("data")["sub_category_organization_id"]["name"], 'province_id' => $item['province_id'], "regency_id" => $item['regency_id']]) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                        @endif

                                        @if ($item['total_responder'] == 0 && $item['total_transaksi'] == 0)
                                        <form action="{{ route('pages.account.partner.hapus', ['institution_id' => $item['institution_id'] ]) }}" method="POST" style="display: inline;">
                                            @csrf   
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                        @endif

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
                <form action="{{ route('pages.accounts.partner.store', ['name' => $dataname]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="regency_id" class="form-label"> Pilih {{ $dataname == "POLSEK" ? "POLSEK" : ($dataname == "KODIM" ? "KODIM" : "POLRES") }} </label>
                                    <select name="regency_id" class="form-control" id="regency_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($keamanan as $item)
                                            <option value="{{ $item['id'] }}|{{ $dataname }}|{{ $item['name'] }}">
                                                {{ $dataname }} {{ $item['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label"> Email </label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Masukkan Email" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="country_code" class="form-label"> Kode Negara </label>
                                    <input type="text" class="form-control" name="country_code" id="country_code"
                                        placeholder="Masukkan Kode Negara" value="{{ old('country_code') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="form-label"> Nomor HP </label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number"
                                        placeholder="Masukkan Nomor HP" value="{{ old('phone_number') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="nama_pic" class="form-label"> Nama PIC </label>
                                    <input type="text" class="form-control" name="nama_pic" id="nama_pic"
                                        placeholder="Masukkan Nama PIC" value="{{ old('nama_pic') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number_pic" class="form-label"> Nomor HP PIC </label>
                                    <input type="text" class="form-control" name="phone_number_pic" id="phone_number_pic"
                                        placeholder="Masukkan Nomor HP PIC" value="{{ old('phone_number_pic') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_organisasi" class="form-label"> Alamat </label>
                            <textarea name="alamat_organisasi" class="form-control" id="alamat_organisasi" rows="5" placeholder="Masukkan Alamat Organisasi">{{ old('alamat_organisasi') }}</textarea>
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
