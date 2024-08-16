@extends('pages.layouts.main')

@section('title', 'Akun Admin')

@section('component-css')
    <link href="{{ url('public/template') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ URL::asset('template') }}/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
        rel="stylesheet">
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

        <a href="{{ route('pages.accounts.admin.index') }}" class="btn btn-danger" style="margin-top: 5px;">
            <i class="fa fa-sign-out"></i> Kembali
        </a>
        <button onclick="upgrade({{ $detail['id_master_organization'] }})" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" style="margin-top: 5px">
            <i class="fa fa-edit"></i> Upgrade
        </button>

        <div class="row" style="margin-top: 10px">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Detail @yield('title')
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Nama
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['nama'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Kode Akun Member
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['member_account_code'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Username
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['username'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Kode Negara
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['country_code'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Nomor HP
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['phone_number'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Dibuat Tanggal
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                @php
                                    $timestamps = $detail['created_at'];

                                    $carbonDate = \Carbon\Carbon::createFromTimestamp($timestamps);
                                    $formattedDateTime = $carbonDate->format('d-m-Y, H:i:s');
                                @endphp
                                {{ $formattedDateTime }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Waktu Tersisa
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $remaining['returnDate'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Detail Paket Organisasi
                        </h2>
                        {{-- <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                            data-target=".bs-example-modal-lg">
                            <i class="fa fa-plus"></i> Tambah
                        </button> --}}
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Nama Paket
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                {{ $detail['paketOrganization']['nama_paket'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Limit Responder
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                {{ $detail['paketOrganization']['limit_contact'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Limit User
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                {{ $detail['paketOrganization']['limit_user'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Deskripsi
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                {{ empty($detail['paketOrganization']['description']) ? '-' : $detail['paketOrganization']['description'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Durasi Waktu
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                {{ $detail['paketOrganization']['durationDate'] }} Hari
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Harga
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                Rp. {{ number_format($detail['paketOrganization']['amount']) }}
                            </div>
                        </div>
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
                        <i class="fa fa-edit"></i> Upgrade
                    </h4>
                </div>
                <div id="modal-content-upgrade">

                </div>
            </div>
        </div>
    </div>

@endsection

@section("component-js")

    <script type="text/javascript">
        function upgrade(id_master_organization)
        {
            $.ajax({
                url: "{{ url('/pages/account/admin') }}" + "/" + id_master_organization + "/upgrade",
                method: "GET",
                success: function(response) {
                    $("#modal-content-upgrade").html(response)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    </script>

@endsection
