<div class="modal-body">
    <center>
        {{-- <div class="x_title">
            <h2>
                {{ $paketSaatIni['nama_paket'] }}
            </h2>
            <div class="clearfix"></div>
        </div> --}}
    </center>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="limit-user" class="form-label"> Jumlah User Saat Ini </label>
                <input type="text" id="limit-user" name="limit-user" class="form-control"
                    value="{{ $saatIni['detailMembership']['limit_user'] }}">
                <small class="text-danger fw-bold">
                    Catatan : Anda Dapat Menambahkan Atau Mengurangi Jumlah User
                </small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="tambah-user" class="form-label"> Tambah User </label>
                <select name="tambah-user" class="form-control" id="tambah-user">
                    <option value="">- Pilih -</option>
                    <?php for ($i = 10; $i <= 100; $i += 10) : ?>
                    <option value="{{ $i }}">
                        {{ $i }} User
                    </option>
                    <?php endfor ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="limitKontak" class="form-label"> Kontak Saat Ini </label>
        <input type="text" class="form-control" id="limitKontak" name="" readonly
            value="{{ $paketSaatIni['limit_contact'] }}">
    </div>

    @if ($code !== '001')
        <input type="hidden" name="code" id="code" value="{{ $code }}">
        <div class="form-group">
            <label for="masa_aktif_paket" class="form-label"> Masa Aktif Paket </label>
            <select name="masa_aktif_paket" class="form-control" id="masa_aktif_paket">
                <option value="">- Pilih -</option>
                <option value="3">90 Hari</option>
                <option value="6">180 Hari</option>
                <option value="12">365 Hari</option>
            </select>
        </div>
    @else
        <div class="form-group">
            <label class="form-label"> Masa Aktif </label>
            <input type="text" class="form-control" value="365 Hari" readonly>
        </div>
    @endif

    <div class="form-group">
        <label class="form-label"> Total Harga </label>
        <input type="text" id="total-harga" class="form-control" value="Rp 0" readonly>
    </div>
    <small class="text-danger fw-bold">
    Catatan : Dengan membeli paket baru, sisa masa aktif paket yang sebelumnya akan hangus
</small>
</div>
<div class="modal-footer">
    <button class="btn btn-success text-uppercase btn-block" id="btn-pembayaran">
        <i class="fa fa-edit" style="margin-right: 5px"></i> Lanjutkan Pembayaran
    </button>
</div>

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

    $(document).ready(function() {

        function checkPricePaket() {

            let limituser = parseInt($("#limit-user").val()) || 0;
            let tambahUser = parseInt($("#tambah-user").val()) || 0;
            let durationDate = parseInt($("#masa_aktif_paket").val()) || 0;

            let totalUser = limituser + tambahUser;

            let dataCode;

            if (@json($code) != "001") {
                dataCode = @json($code);
            } else {
                dataCode = @json($detail);
            }

            let member_account_code = @json(session('data')['member_account_code']);

            $.ajax({
                url: "{{ url('/check-price-paket') }}",
                type: "POST",
                data: {
                    limituser: totalUser,
                    code: dataCode,
                    durationDate: durationDate,
                    member_account_code: member_account_code,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == true) {

                        if (response.data.nama_paket == "Custom") {
                            let formattedAmount = formatRupiah(response.data.amount);
                            $("#total-harga").val(formattedAmount);
                        } else {
                            if (response.data.amount_ganti_paket == 0) {
                                $("#total-harga").val(0)
                            } else {
                                let formattedAmount = formatRupiah(response.data.amount_ganti_paket);
                                $("#total-harga").val(formattedAmount);
                            }
                        }
                    } else if (response.status == false) {
                        console.log(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $("#masa_aktif_paket").on('change', function() {
            checkPricePaket();
        });

        checkPricePaket();

        $("#limit-user").on('input', function() {
            checkPricePaket()
        });

        $("#tambah-user").on('change', function() {
            checkPricePaket();
        });

        $("#btn-pembayaran").click(function() {
            let harga = $("#total-harga").val();
            let limit_user = $("#limit-user").val();
            let code = $("#code").val()
            let id_master = @json($detail);
            let limit_contact = @json($paketSaatIni['limit_contact']);

            let durasi;
            if (code != "001") {
                durasi = $("#masa_aktif_paket").val()

                if (durasi == "3") {
                    durasi = 90;
                } else if (durasi == "6") {
                    durasi = 180
                } else if (durasi == "12") {
                    durasi = 365;
                }
            } else {
                durasi = 365;
            }

            let duration_date = durasi;
            let hargaAmount = harga.replace('Rp ', '').replace(/\./g, '');

            let limituser = parseInt($("#limit-user").val()) || 0;
            let tambahUser = parseInt($("#tambah-user").val()) || 0;
            let totalUser = limituser + tambahUser;

            $.ajax({
                url: "{{ url('/pages/master/paket/store') }}",
                type: "POST",
                data: {
                    idMasterPaket: id_master,
                    amount: hargaAmount,
                    limit_user: totalUser,
                    limit_contact: limit_contact,
                    end_date: duration_date,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == true) {
                        window.location.href = "/pages/payment/checkout";
                    } else if (response.status == false) {
                        console.log(error);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })
    });

    document.getElementById('limit-user').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');

        if (value !== '' && parseInt(value) < 1) {
            value = 1;
        }

        e.target.value = value;
    });
</script>
