@extends('pages.layouts.main')

@section('title', 'Responder')

@section('component-css')
    <link href="{{ dynamic_asset('template') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ dynamic_asset('template') }}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ dynamic_asset('template') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ dynamic_asset('template') }}/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <link href="{{ dynamic_asset('template') }}/build/css/custom.min.css" rel="stylesheet">
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
                            {{ $detailMembership['total_responder'] }} /
                            {{ $detailMembership['limit_contact'] }}
                        </button>
                        <div class="clearfix"></div>

                    </div>
                    @if ($detailMembership['total_responder'] > $detailMembership['limit_contact'])
                        <p>
                            Silahkan non-aktifkan responder anda, karena telah melebihi limit. Agar Alert button dapat digunakan
                        </p>
                    @endif
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    {{-- <th class="text-center">Kode Akun Member</th> --}}
                                    <th class="text-center">Nomor HP</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Org</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($responder as $item)
                                    <tr>
                                        <td class="text-center">{{ ++$nomer }}.</td>
                                        <td>{{ $item['detail']['nama'] }}</td>
                                        {{-- <td class="text-center">{{ $item['detail']['member_account_code'] }}</td> --}}
                                        <td class="text-center">{{ $item['detail']['phone_number'] }}</td>
                                        <td class="text-center">
                                            {{ empty($item['detail']['username']) ? '-' : $item['detail']['username'] }}
                                        </td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input {{ $item['detail']['account_status_id'] == "active" ? 'checked' : '' }} type="checkbox" class="custom-control-input js-switch"
                                                    id="customSwitch{{ $item['detail']['id_responder_organization'] }}"
                                                    data-id="{{ empty($item['detail']['id_request_contact']) ? $item['detail']['id_responder_organization'] : $item['detail']['id_request_contact'] }}" data-tipe="{{ $item['detail']['org'] }}">
                                                <label class="custom-control-label text-uppercase"
                                                    for="customSwitch{{ $item['detail']['id_responder_organization'] }}">
                                                    {{ $item['detail']['account_status_id'] }}
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item['detail']['nama_institusi'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('pages.accounts.responder.show', ['username' => $item['detail']['username'], 'org' => $item['detail']['org'], 'id_req_contact' => empty($item['detail']['id_request_contact']) ? '0' : $item['detail']['id_request_contact'] ])}}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-search"></i> Detail
                                            </a>
                                            <form
                                                action="{{ route('pages.accounts.responder.destroy', ['idUser' => empty($item['detail']['id_request_contact']) ? $item['detail']['id_responder_organization'] : $item['detail']['id_request_contact'], 'org' => $item['detail']['org']]) }}"
                                                method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Yakin ? Ingin Menghapus Data Ini?')"
                                                    type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
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
                <form
                    action="{{ route('pages.accounts.responder.store', ['member_account_code' => session('data.member_account_code')]) }}"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- <div class="form-group">
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
                                placeholder="Masukkan Kode Negara" value="{{ old('country_code') }}">
                        </div> --}}
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="nama" class="form-label"> Nama </label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        placeholder="Masukkan Nama" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_code" class="form-label"> Kode Negara </label>
                                    <input type="text" class="form-control" name="country_code" id="country_code"
                                        placeholder="Masukkan Kode Negara">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="email" class="form-label"> Email </label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Masukkan Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="form-label"> Nomor HP </label>
                                    <input type="number" class="form-control" name="phone_number" id="phone_number"
                                        placeholder="Masukkan Nomor HP" value="{{ old('phone_number') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="unique_responder_id" class="form-label"> Kode Referensi (Opsional) </label>
                            <input type="text" class="form-control" name="unique_responder_id" id="unique_responder_id" placeholder="Masukkan Kode Referensi">
                            <small class="text-danger">
                                *Catatan : Tidak Perlu Mengisi Kolom Yang Lain, Jika Memiliki Kode Referensi
                            </small>
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

@section('component-js')
    <script src="{{ dynamic_asset('template') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ dynamic_asset('template') }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ dynamic_asset('template') }}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js">
    </script>
    <script src="{{ dynamic_asset('template') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ dynamic_asset('template') }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="{{ dynamic_asset('template') }}/vendors/switchery/dist/switchery.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function updateStatus(username) {
            $.ajax({
                url: "{{ url('/pages/account/responder') }}" + "/" + username,
                type: "PUT",
                success: function(response) {
                    if (response.status == true) {
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }

                    window.location.reload()
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll(".js-switch");

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    let checked = checkbox.checked;
                    let idUser = checkbox.getAttribute('data-id');
                    let cekData = checkbox.getAttribute("data-tipe");

                    $.ajax({
                        url: "{{ url('/pages/account/responder') }}" + "/" + idUser +
                            "/change-status",
                        type: "POST",
                        data: {
                            checked: checked,
                            tipe: cekData
                        },
                        success: function(response) {
                            if (response.status == true) {
                                alert(response.message);

                                window.location.reload();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        });
    </script>

@endsection
