@extends('pages.layouts.main')


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

        <a href="" class="btn btn-danger btn-sm">
            <i class="fa fa-sign-out"></i> Kembali
        </a>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Data Responder
                        </h2>
                        {{-- <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                            data-target=".bs-example-modal-lg">
                            <i class="fa fa-plus"></i> Tambah
                        </button> --}}
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">ID Institusi</th>
                                    <th>Nama</th>
                                    <th class="text-center">Nomor HP</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Kode Referensi</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($response as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td class="text-center">{{ $item["institution_id"] }}</td>
                                    <td>{{ $item["name"] }}</td>
                                    <td class="text-center">{{ $item['phone_number'] }}</td>
                                    <td class="text-center">{{ $item["email"] }}</td>
                                    <td class="text-center">{{ $item['unique_responder_id'] }}</td>
                                    {{-- <td class="text-center">
                                        <a href="{{ route('pages.account.partner.lihat-polsek', ['name' => 1, 'province_id' => session("data")["province_id"], "regency_id" => session("data")["regency_id"]]) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
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
