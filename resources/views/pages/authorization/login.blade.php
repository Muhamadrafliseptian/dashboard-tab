<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>
        {{ config('app.name') }} - Login Aplikasi
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ url('public/template/images/LOGO-TAB-TNOS.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,
        body {
            font-family: 'Franklin Gothic', 'Arial Narrow', Arial, sans-serif;
            height: 100%;
            background: linear-gradient(to bottom, #d3d3d3, #808080); /* Gray gradient background */
        }
    </style>
</head>

<body class="my-login-page">
    <br><br>
    <div class="row p-0 m-0" style="justify-content: center; align-items: center;">
        <div class="col-md-5">
            @if (session("success"))
            <div class="alert alert-success text-uppercase">
                {!! session("success") !!}
            </div>
            @elseif(session("error"))
            <div class="alert alert-danger text-uppercase">
                {!! session("error") !!}
            </div>
            @endif
            <div class="card">
                <form method="POST" action="{{ route('pages.login.post-login') }}">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="image">
                            <center>
                                <img src="{{ url('public/template/images/LOGO-TAB-TNOS.png') }}"
                                    style="width: 20%; height: 20%">
                            </center>
                        </div>
                        <h4 class="text-center" style="margin-top: 20px">
                            {{ config('app.name') }}
                        </h4>
                        <h6 class="text-center" style="color: gray">
                            Silahkan Login Terlebih Dahulu Untuk Memulai Monitoring
                        </h6>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control " name="username" id="username"
                                placeholder="Masukkan Username" required value="{{ old('username') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">KATA SANDI</label>
                            <input type="password" class="form-control " name="password" id="password"
                                placeholder="Masukkan Password" required data-eye>
                        </div>
                        <div class="form-group pull-right mt-2 mb-2">
                            <a target="_blank" href="{{ url('/pages/lupa-password') }}">
                                Lupa Password ?
                            </a>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="width: 100%; background-color: #00A0F0">
                            <i class="fa fa-sign-in"></i> Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script>
        $(function() {

            $("input[type='password'][data-eye]").each(function(i) {
                var $this = $(this),
                    id = 'eye-password-' + i,
                    el = $('#' + id);

                $this.wrap($("<div/>", {
                    style: 'position:relative',
                    id: id
                }));

                $this.css({
                    paddingRight: 60
                });
                $this.after($("<div/>", {
                    html: '<i class="fa fa-eye"></i>',
                    id: 'passeye-toggle-' + i,
                }).css({
                    position: 'absolute',
                    right: 10,
                    top: ($this.outerHeight() / 2) - 12,
                    padding: '2px 7px',
                    fontSize: 12,
                    cursor: 'pointer',
                }));

                $this.after($("<input/>", {
                    type: 'hidden',
                    id: 'passeye-' + i
                }));

                var invalid_feedback = $this.parent().parent().find('.invalid-feedback');

                if (invalid_feedback.length) {
                    $this.after(invalid_feedback.clone());
                }

                $this.on("keyup paste", function() {
                    $("#passeye-" + i).val($(this).val());
                });
                $("#passeye-toggle-" + i).on("click", function() {
                    if ($this.hasClass("show")) {
                        $this.attr('type', 'password');
                        $this.removeClass("show");
                        $(this).removeClass("btn-outline-primary");
                    } else {
                        $this.attr('type', 'text');
                        $this.val($("#passeye-" + i).val());
                        $this.addClass("show");
                        $(this).addClass("btn-outline-primary");
                    }
                });
            });

            $(".my-login-validation").submit(function() {
                var form = $(this);
                if (form[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.addClass('was-validated');
            });
        });
    </script>
</body>

</html>
