@extends('pages.layouts.main')

@section('title', 'Report Panic')

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
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th class="text-center">Nomor HP</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam</th>
                                    <th>Nama Responder</th>
                                    <th class="text-center">Nomor HP Responder</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($panicReport as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td>{{ $item["nama"] }}</td>
                                    <td class="text-center">{{ $item["phone_number"] }}</td>
                                    <td class="text-center">{{ $item["tanggal"] }}</td>
                                    <td class="text-center">{{ $item["jam"] }}</td>
                                    <td>{{ $item["responder_name"] }}</td>
                                    <td class="text-center">{{ $item["responder_phone_number"] }}</td>
                                    <td class="text-center">{{ $item["status"] }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pages.report.panic.show', ['id_panic' => $item['id_panic']]) }}" class="btn btn-success btn-sm">
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

@endsection

@section("component-js")
<script src="{{ url('public/template') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
@endsection
