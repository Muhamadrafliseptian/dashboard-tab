@extends('pages.layouts.main')

@section('title', 'Akses Role')

@section('component-css')
    <link href="{{ url('public/template') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
        rel="stylesheet">
    <link href="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
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
                                    <th class="text-center">Nama Akses Role</th>
                                    <th class="text-center">Level</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0;
                                @endphp
                                @foreach ($role as $item)
                                    <tr>
                                        <td class="text-center">{{ ++$nomer }}.</td>
                                        <td class="text-center">{{ empty($item['role_name']) ? '-' : $item['role_name'] }}
                                        </td>
                                        <td class="text-center">{{ empty($item['level_role']) ? '-' : $item['level_role'] }}
                                        </td>
                                        <td class="text-center">
                                            <button onclick="editData($item['id_role_organization'])" type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target=".bs-edit-modal-lg">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('pages.pengaturan.role.destroy', ['id' => $item['id_role_organization']]) }}" method="POST" style="display: inline">
                                                @csrf
                                                @method("DELETE")
                                                <button onclick="return confirm('Yakin ? Ingin Menghapus Data Ini?')" type="submit" class="btn btn-danger">
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

    <!-- Tambah Data -->
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
                <form action="{{ route('pages.pengaturan.role.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_name" class="form-label"> Nama Akses Role </label>
                            <input type="text" class="form-control" name="role_name" id="role_name"
                                placeholder="Masukkan Nama" value="{{ old('role_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="level_role" class="form-label"> Level </label>
                            <input type="number" class="form-control" name="level_role" id="level_role" placeholder="0"
                                min="1" value="{{ old('level_role') }}">
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
    <!-- End -->

    <!-- Edit Data -->
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
                <div id="modal-content-edit">

                </div>
            </div>
        </div>
    </div>
    <!-- End -->

@endsection

@section('component-js')
    <script src="{{ url('public/template') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('public/template') }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ url('public/template') }}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js">
    </script>
    <script src="{{ url('public/template') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ url('public/template') }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>

    <script type="text/javascript">
        function editData(id_role_organization)
        {
            $.ajax({
                url: "{{ url('/pages/pengaturan/role') }}" + "/" + id_role_organization + "/edit",
                method: "GET",
                success: function(response) {
                    $("#modal-content-edit").html(response)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    </script>
    @endsection
