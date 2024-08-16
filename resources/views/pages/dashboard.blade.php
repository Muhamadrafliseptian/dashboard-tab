@extends('pages.layouts.main')

@section('title', 'Dashboard')

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
            @if (session('data')['account_category'] == 'PARTNER')
                <div class="col-md-6">
                    <div class="row">
                        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="count">
                                    {{ $totalResponderPartner }}
                                </div>
                                <h3>Responder</h3>
                                <a href="{{ route('pages.responder.akun.index') }}"
                                    class="btn btn-secondary btn-sm btn-block" style="margin-top: 10px;">
                                    <i class="fa fa-sign-in"></i> Pergi Ke Halaman
                                </a>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="count">
                                    {{ $totalTransaksiPartnerUmum }}
                                </div>
                                <h3>Transaksi</h3>
                                <a href="{{ route('pages.transaction.history-payment-partner.index') }}"
                                    class="btn btn-secondary btn-sm btn-block" style="margin-top: 10px;">
                                    <i class="fa fa-sign-in"></i> Pergi Ke Halaman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('data')['account_category'] != 'PARTNER')
                <div class="col-md-6">
                    <div class="row">
                        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="count">
                                    {{ $totalResponder }}
                                </div>
                                <h3>Responder</h3>
                                <a href="{{ route('pages.account.responder.index-admin', ['member_account_code' => session('data')['member_account_code']]) }}"
                                    class="btn btn-secondary btn-sm btn-block" style="margin-top: 10px;">
                                    <i class="fa fa-sign-in"></i> Pergi Ke Halaman
                                </a>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="count">
                                    {{ $totalUser }}
                                </div>
                                <h3>User</h3>
                                <a href="{{ route('pages.accounts.user.index-admin', ['member_account_code' => session('data')['member_account_code']]) }}"
                                    class="btn btn-secondary btn-sm btn-block" style="margin-top: 10px;">
                                    <i class="fa fa-sign-in"></i> Pergi Ke Halaman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Detail Paket
                            </h2>
                            @if (session('data')['account_category'] == 'INTERNAL')
                                @if ($showDetail['detailMembership']['remainingDate'] >= 7)
                                    <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                        data-target=".bs-example-modal-lg">
                                        <i class="fa fa-plus" style="margin-right: 5px"></i> Tambah Limit User
                                    </button>
                                @else
                                    <a href="{{ route('pages.master.paket.index') }}"
                                        class="btn btn-primary btn-sm pull-right">
                                        Beli Paket Baru
                                    </a>
                                @endif
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-4">
                                    Nama Paket
                                </div>
                                <div class="col-md-5">
                                    {{ $showDetail['detailMembership']['nama_paket'] == 'Custom' ? 'Voice Call' : $showDetail['detailMembership']['nama_paket'] }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Status Subscribe
                                </div>
                                <div class="col-md-5">
                                    {{ $showDetail['detailMembership']['status_subscribe'] }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Sisa Masa Aktif
                                </div>
                                <div class="col-md-5">
                                    {{ $showDetail['detailMembership']['remainingDate'] }} Hari
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Limit User
                                </div>
                                <div class="col-md-5">
                                    {{ $showDetail['detailMembership']['limit_user'] }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Limit Responder
                                </div>
                                <div class="col-md-5">
                                    {{ $showDetail['detailMembership']['limit_contact'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (session('data')['account_category'] != 'PARTNER')
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
                    <div class="modal-body">
                        <input type="hidden" name="code" value="{{ $showDetail['detailMembership']['code'] }}">
                        @if ($showDetail['detailMembership']['code'])
                            <input type="hidden" name="id_master_paket_organization"
                                value="{{ $showDetail['detailMembership']['id_master_paket_organization'] }}">
                        @endif
                        <input type="hidden" name="limit_user"
                            value="{{ $showDetail['detailMembership']['limit_user'] }}">
                        <input type="hidden" name="member_account_code"
                            value="{{ $showDetail['detailMembership']['member_account_code'] }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jumlah-user" class="form-label"> Jumlah User </label>
                                    <input type="number" min="1" class="form-control" name="jumlah-user"
                                        id="jumlah-user" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="harga" class="form-label"> Harga </label>
                            <div id="harga">
                                Rp. 0
                            </div>
                            <input type="hidden" name="limit_user_new" id="limit_user_new">
                        </div>
                        <small class="text-danger fw-bold">
                            Catatan : Masa aktif user menyesuaikan sisa waktu paket (
                            {{ $showDetail['detailMembership']['remainingDate'] }} Hari
                            )

                        </small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-sm btn-block" id="btn-pembayaran">
                            <i class="fa fa-edit"></i> Lanjutkan Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('component-js')
    <script type="text/javascript">
        function formatRupiah(amount) {
            let number_string = amount.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp ' + rupiah;
        }

        function checkPrice() {
            let jumlahUser = $("#jumlah-user").val();
            let code = $("input[name='code']").val();
            let limitUser = $("input[name='limit_user']").val();
            let member_account_code = $("input[name='member_account_code']").val();

            let id_master_paket_organization;
            let idPaket;
            if (code == "001") {
                id_master_paket_organization = $("input[name='id_master_paket_organization']").val();
                idPaket = $("input[name='id_master_paket_organization']").val();
            } else {
                id_master_paket_organization = code;
                idPaket = $("input[name='id_master_paket_organization']").val();
            }

            if (jumlahUser && jumlahUser > 0) {
                $.ajax({
                    url: "{{ url('/check-komersil') }}",
                    method: "POST",
                    data: {
                        code: id_master_paket_organization,
                        id_master_paket_organization: idPaket,
                        add_on_user: jumlahUser,
                        limit_user: limitUser,
                        member_account_code: member_account_code,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log('====================================');
                        console.log(response);
                        console.log('====================================');
                        if (response.status == true) {
                            let formattedAmount = formatRupiah(response.data.amount);
                            $("#limit_user_new").val(response.data.total_all_user);
                            $("#harga").text(formattedAmount);
                        } else if (response.status == false) {
                            console.log(response.message);
                        }
                    },
                    error: function(error) {
                        console.log('====================================');
                        console.log('error');
                        console.log('====================================');
                        console.log(error.message);
                    }
                });
            }
        }

        $(document).ready(function() {
            $("#btn-check").click(function() {
                checkPrice();
            });

            $("#jumlah-user").on('input', function() {
                checkPrice();
            });

            $("#btn-pembayaran").click(function() {
                let harga = $("#harga").text();
                let hargaAmount = harga.replace('Rp ', '').replace(/\./g, '');
                let limit_user_new = $("input[name='limit_user_new']").val();
                let member_account_code = $("input[name='member_account_code']").val();

                $.ajax({
                    url: "{{ url('/pages/pembayaran-internal') }}",
                    type: "POST",
                    data: {
                        limit_user: limit_user_new,
                        amount: hargaAmount,
                        member_account_code: member_account_code,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == true) {
                            window.location.href = "/pages/payment/checkout";
                        } else if (response.status == false) {
                            console.log(response.message);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

@endsection
