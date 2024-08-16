@extends('pages.layouts.main')

@section('title', 'Master Paket')

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
            @if ($code == "001")
            @foreach ($masterpaket as $item)
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <center>
                                <div class="x_title">
                                    <h2>
                                        {{ $item['nama_paket'] }}
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                            </center>
                            <p>
                                Nama Paket : {{ $item['nama_paket'] }}
                                <br>
                                Limit User : {{ $item['limit_user'] }}
                                <br>
                                Limit Responder : {{ $item['limit_contact'] }}
                                <br>
                                Harga Dasar : Rp. {{ number_format($item['amount']) }}
                                <br>
                                Mengikuti : {{ $item['durationDate'] }} Hari
                            </p>
                            <div class="form-group">
                                <button onclick="detailPaket({{ $item['id_master_paket_organization'] }}, `{{ $code }}`)" type="button"
                                    class="btn btn-primary btn-sm text-uppercase btn-block" data-toggle="modal"
                                    data-target=".bs-example-modal-lg">
                                    <i class="fa fa-edit" style="margin-right: 5px"></i> Beli Paket Baru
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <center>
                            <div class="x_title">
                                <h2>
                                    {{ $masterpaket['nama_paket'] }}
                                </h2>
                                <div class="clearfix"></div>
                            </div>
                        </center>
                        <p>
                            Nama Paket : {{ $masterpaket['nama_paket'] }}
                            <br>
                            Limit User : {{ $masterpaket['limit_user'] }}
                            <br>
                            Limit Responder : {{ $masterpaket['limit_contact'] }}
                            <br>
                            Harga Dasar : Rp. {{ number_format($masterpaket['amount']) }}
                            <br>
                            Mengikuti : {{ $masterpaket['duration_date'] }} Hari
                        </p>
                        <div class="form-group">
                            <button onclick="detailPaket({{ $masterpaket['id_master_paket_organization'] }}, `{{ $code }}`)" type="button"
                                class="btn btn-primary btn-sm text-uppercase btn-block" data-toggle="modal"
                                data-target=".bs-example-modal-lg">
                                <i class="fa fa-edit" style="margin-right: 5px"></i> Beli Paket Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        <i class="fa fa-edit"></i> Beli Paket Baru
                    </h4>
                </div>
                <div id="modal-content-data">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('component-js')

    <script type="text/javascript">
        function detailPaket(id_master_paket_organization, code) {
            $.ajax({
                url: "{{ url('/pages/master/paket') }}" + "/" + id_master_paket_organization + "/" + code + "/get-data",
                type: "GET",
                success: function(response) {
                    $("#modal-content-data").html(response)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    </script>

@endsection
