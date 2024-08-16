<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li>
                <a href="{{ route('pages.dashboard') }}">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>
            @if (session('data')['account_category'] == 'INTERNAL')
                {{-- @if ($showDetail['detailMembership']['remainingDate'] <= 7)

                @endif --}}
                @if (session("internal")["detailMembership"]["remainingDate"] < 7)
                <li>
                    <a>
                        <i class="fa fa-book"></i> Master
                        <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="{{ route('pages.master.paket.index') }}"> Paket </a>
                        </li>
                    </ul>
                </li>
                @endif
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
            @endif
            @if (session('data')['account_category'] == 'EKSTERNAL')
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
            @endif

            <li>
                <a>
                    <i class="fa fa-users"></i> Akun
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a
                            href="{{ route('pages.account.responder.index-admin', ['member_account_code' => session('data.member_account_code')]) }}">Responder</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('pages.accounts.user.index-admin', ['member_account_code' => session('data.member_account_code')]) }}">User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-book"></i> Insiden
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a
                            href="{{ route('pages.report.panic.index', ['member_account_code' => session('data.member_account_code')]) }}">
                            Panic
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-gears"></i> Pengaturan
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="{{ route('pages.account.profil.index') }}">Profil Saya</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</div>
