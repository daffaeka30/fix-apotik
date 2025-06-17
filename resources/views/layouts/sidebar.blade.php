<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <div class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ url($setting->path_logo) }}" alt="Logo" width="40">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"
                style="font-size: 14px; text-transform: none !important;">
                {{ ucwords(strtolower($setting->nama_perusahaan)) }}
            </span>

        </div>


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        @if (auth()->user()->level == 1)
            <!-- MASTER -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">MASTER</span>
            </li>
            <li class="menu-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                <a href="{{ route('kategori.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Kategori">Kategori</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('produk.index') ? 'active' : '' }}">
                <a href="{{ route('produk.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-package"></i>
                    <div data-i18n="Basic">Produk</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('member.index') ? 'active' : '' }}">
                <a href="{{ route('member.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-id-card"></i>
                    <div data-i18n="Basic">Member</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('supplier.index') ? 'active' : '' }}">
                <a href="{{ route('supplier.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-truck"></i>
                    <div data-i18n="Supplier">Supplier</div>
                </a>
            </li>

            <!-- TRANSAKSI -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">TRANSAKSI</span></li>
            <li class="menu-item {{ request()->routeIs('pengeluaran.index') ? 'active' : '' }}">
                <a href="{{ route('pengeluaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-receipt"></i>
                    <div data-i18n="Basic">Pengeluaran</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('pembelian.index') ? 'active' : '' }}">
                <a href="{{ route('pembelian.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                    <div data-i18n="Basic">Pembelian</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('penjualan.index') ? 'active' : '' }}">
                <a href="{{ route('penjualan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-upload"></i>
                    <div data-i18n="Basic">Penjualan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                <a href="{{ route('transaksi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-cart-download"></i>
                    <div data-i18n="Basic">Transaksi Aktif</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('transaksi.baru') ? 'active' : '' }}">
                <a href="{{ route('transaksi.baru') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Basic">Transaksi Baru</div>
                </a>
            </li>

            <!-- REPORT -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">REPORT</span></li>
            <li class="menu-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                <a href="{{ route('laporan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-report"></i>
                    <div data-i18n="Basic">Laporan</div>
                </a>
            </li>

            <!-- SYSTEM -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">SYSTEM</span></li>
            <li class="menu-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Basic">User</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                <a href="{{ route('setting.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-cog"></i>
                    <div data-i18n="Basic">Pengaturan</div>
                </a>
            </li>
        @else
            <li class="menu-header small text-uppercase"><span class="menu-header-text">TRANSAKSI</span></li>
            <!-- Cards -->
            <li class="menu-item {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                <a href="{{ route('transaksi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-cart-download"></i>
                    <div data-i18n="Basic">Transaksi Aktif</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('transaksi.baru') ? 'active' : '' }}">
                <a href="{{ route('transaksi.baru') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Basic">Transaksi Baru</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
