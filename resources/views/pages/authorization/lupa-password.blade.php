<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>
        {{ config('app.name') }}
    </title>
    <link rel="icon" type="image/png" href="{{ URL::asset('template/images/IMAGE-LOGO-TNOS.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,
        body {
            font-family: 'Franklin Gothic', 'Arial Narrow', Arial, sans-serif;
            height: 100%;
        }
    </style>
</head>

<body class="my-login-page" style="background-color: #6395B9
;">
    <div style="margin-top: 60px"></div>
    <div class="row p-0 m-0" style="justify-content: center; align-items: center;">
        <div class="col-md-5">


            <div class="card">
                <form action="https://trackormawa.polindra.ac.id/lupa_password" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="image">
                            <center>
                                <img src="{{ url('/template/images/IMAGE-LOGO-TNOS.png') }}"
                                    style="width: 20%; height: 20%">
                            </center>
                        </div>
                        <h4 class="text-center" style="margin-top: 20px">
                            Lupa Password
                        </h4>
                        <h6 class="text-center" style="color: gray">
                            Silahkan Isikan Email Valid Untuk Mengganti Password Anda
                        </h6>

                        <div class="form-group">
                            <label for="email">E - MAIL</label>
                            <input type="text" class="form-control " name="email" id="email"
                                placeholder="Masukkan E - Mail" value="">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="width: 100%; background-color: #00A0F0">
                            Kirim
                        </button>
                        <hr>
                        <a href="{{ url('/pages/login') }}">
                            Kembali Ke Halaman Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>
