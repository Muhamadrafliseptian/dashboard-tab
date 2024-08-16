@extends('pages.layouts.main')

{{-- @section('title', 'Detail Data Panic') --}}

@section('component-css')
    <link href="{{ url('public/template') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
        rel="stylesheet">
    <style>
        #map {
            height: 300px;
            /* Sesuaikan tinggi peta sesuai kebutuhan */
            width: 100%;
        }
    </style>
@endsection

@section('content-page')

    @php
        $lokasi = json_decode($detail['lokasi']);
    @endphp
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

        <a href="{{ route('pages.report.panic.index', ['member_account_code' => session('data')['member_account_code']]) }}"
            class="btn btn-danger" style="margin-top: 5px;">
            <i class="fa fa-sign-out"></i> Kembali
        </a>

        @php
            $lokasi = json_decode(stripslashes($detail['lokasi']), true);
            $lokasi_user = json_decode(stripslashes($detail['lokasi_user']), true);
            $lokasi_responder = json_decode(stripslashes($detail['lokasi_responder']), true);
        @endphp

        <div class="row" style="margin-top: 10px">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Detail Data User
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Nama
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['name'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Longitude
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $lokasi['longitude'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Nomor HP
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ empty($detail['phone_number']) ? '-' : $detail['phone_number'] }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Tanggal Kejadian
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['tanggal'] }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Waktu Kejadian
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                {{ $detail['jam'] }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                Status
                            </label>
                            <div class="col-md-5 col-sm-9 col-xs-12">
                                @if ($detail['statuss'] == 'P')
                                    <button disabled class="btn btn-danger btn-sm fw-bold text-uppercase">
                                        Sedang Ditangani
                                    </button>
                                @elseif($detail['statuss'] == 'W')
                                    <button disabled class="btn btn-warning btn-sm fw-bold text-uppercase">
                                        Menunggu
                                    </button>
                                @elseif($detail['statuss'] == 'D')
                                    <button disabled class="btn btn-success btn-sm fw-bold text-uppercase">
                                        Selesai
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            @if ($detail['statuss'] == 'P' || $detail['statuss'] == 'D')
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Detail Data Responder
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                    Nama
                                </label>
                                <div class="col-md-5 col-sm-9 col-xs-12">
                                    {{ $detail['responder_name'] }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                    Nomor HP
                                </label>
                                <div class="col-md-5 col-sm-9 col-xs-12">
                                    {{ $detail['phone_number_responder'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2>
                Detail Lokasi Kejadian
            </h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="map"></div>
        </div>
    </div>

@endsection

@section('component-js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYBzqp2zGPtI0xnr8N8nN_OjsxxzBB9nw&callback=initMap" async
        defer></script>
    <script>
        var detail = @json($detail);

        function initMap() {
            var location1 = {
                lat: {{ $lokasi['latitude'] }},
                lng: {{ $lokasi['longitude'] }}
            };

            var location2 = {
                lat: {{ $lokasi_user['latitude'] }},
                lng: {{ $lokasi_user['longitude'] }}
            };

            var location3 = {
                lat: {{ $lokasi_responder['latitude'] }},
                lng: {{ $lokasi_responder['longitude'] }}
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: location1
            });

            var icon1 = {
                url: "{{ URL::asset('image/ICON-KEJADIAN.jpeg') }}",
                scaledSize: new google.maps.Size(30, 30)
            }

            var icon2 = {
                url: "{{ URL::asset('image/ICON-USER.jpeg') }}",
                scaledSize: new google.maps.Size(30, 30)
            }

            var icon3 = {
                url: "{{ URL::asset('image/ICON-RESPONDER.jpeg') }}",
                scaledSize: new google.maps.Size(30, 30)
            }

            if (detail.statuss == "D") {
                var marker1 = new google.maps.Marker({
                    position: location1,
                    map: map,
                    title: 'Lokasi Kejadian',
                    icon: icon1
                });

                var infoWindow1 = new google.maps.InfoWindow({
                    content: `
                    <strong>Latitude : {{ $lokasi['latitude'] }} </strong>
                    <br>
                    <strong>Longitude : {{ $lokasi['longitude'] }} </strong>
                `
                });

                marker1.addListener('click', function() {
                    infoWindow1.open(map, marker1);
                });
            } else {
                var marker1 = new google.maps.Marker({
                    position: location1,
                    map: map,
                    title: 'Lokasi Kejadian',
                    icon: icon1
                });

                var marker2 = new google.maps.Marker({
                    position: location2,
                    map: map,
                    title: 'Lokasi User',
                    icon: icon2
                });

                var marker3 = new google.maps.Marker({
                    position: location3,
                    map: map,
                    title: 'Lokasi Responder',
                    icon: icon3
                });

                var infoWindow1 = new google.maps.InfoWindow({
                    content: `
                    <strong>Latitude : {{ $lokasi['latitude'] }} </strong>
                    <br>
                    <strong>Longitude : {{ $lokasi['longitude'] }} </strong>
                `
                });

                var infoWindow2 = new google.maps.InfoWindow({
                    content: `
                    <strong>Nama User : {{ $detail['name'] }} </strong>
                `
                });

                var infoWindow3 = new google.maps.InfoWindow({
                    content: `
                    <strong>Nama Responder : {{ $detail['responder_name'] }} </strong>
                `
                });

                marker1.addListener('click', function() {
                    infoWindow1.open(map, marker1);
                });

                marker2.addListener('click', function() {
                    infoWindow2.open(map, marker2);
                });

                marker3.addListener('click', function() {
                    infoWindow3.open(map, marker3);
                });
            }
        }
    </script>
@endsection
