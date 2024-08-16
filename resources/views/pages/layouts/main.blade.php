<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        .: {{ config('app.name') }} - @yield('title') :.
    </title>

    <link rel="icon" type="image/png" href="{{ URL::asset('template/images/LOGO-TAB-TNOS.png') }}" />
    @include('pages.layouts.components.css.style-css')

    @yield('component-css')

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ route('pages.dashboard') }}" class="site_title">
                            <i class="fa fa-home"></i>
                            <span>
                                T A B
                            </span>
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ url('public/template/images/img.jpg') }}" alt="..."
                                class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2 class="text-uppercase">
                                {{ session('data.nama') }}
                            </h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    @if (session('data.role_id.role_name') == 'superadmin')
                        @include('pages.layouts.components.sidebar.sidebar')
                    @elseif(session('data.role_id.role_name') == 'admin')
                        @include('pages.layouts.components.sidebar.sidebar-admin')
                    @elseif(session('data.role_id.role_name') == 'partner')
                        @include('pages.layouts.components.sidebar.sidebar-partner')
                    @endif

                </div>
            </div>

            @include('pages.layouts.components.topbar.navbar-top')

            <div class="right_col" role="main">
                @yield('content-page')
            </div>

            @include('pages.layouts.components.footer.footer')

        </div>
    </div>

    @include('pages.layouts.components.javascript.style-js')

    @yield('component-js')

</body>

</html>
