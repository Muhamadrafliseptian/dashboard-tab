<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li>
                <a href="{{ route('pages.dashboard') }}">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a>
                    <i class="fa fa-home"></i> Dashboard Page
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="index.html">Responder</a></li>
                    <li><a href="index2.html">Insiden</a></li>
                    <li><a href="index3.html">Transaksi</a></li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-money"></i> Transaksi
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="{{ route('pages.transaction.history-payment.index') }}"> Riwayat Pembayaran </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-users"></i> Akun
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="{{ route('pages.accounts.admin.index') }}">Administrator</a>
                    </li>
                    <li>
                        <a href="{{ route('pages.accounts.user.index') }}">User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-gears"></i> Pengaturan
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="index.html">Profil Saya</a></li>
                    <li>
                        <a href="{{ route('pages.pengaturan.role.index') }}">Akses Role</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</div>
