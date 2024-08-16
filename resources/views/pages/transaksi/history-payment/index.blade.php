@extends('pages.layouts.main')

@section('title', 'Riwayat Pembayaran')

@section("component-css")
<link href="{{ dynamic_asset('template') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="{{ dynamic_asset('template') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
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
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Invoice ID</th>
                                    <th>Nama Paket</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Status Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($historyPayment as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td class="text-center">{{ $item["external_id"] }}</td>
                                    <td>{{ $item["nama_paket"] === "Custom" ? "Voice Call" : $item["nama_paket"] }}</td>
                                    <td class="text-center">{{ $item["tanggal"] }}</td>
                                    <td class="text-center">Rp. {{ number_format($item["amount"]) }}</td>
                                    <td class="text-center">{{ $item["status_transaksi"] }}</td>
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
<script src="{{ dynamic_asset('template') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ dynamic_asset('template') }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ dynamic_asset('template') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ dynamic_asset('template') }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
@endsection
