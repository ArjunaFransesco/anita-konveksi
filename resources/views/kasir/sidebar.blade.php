<li class="{{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
    <a href="{{ route('kasir.dashboard') }}">
        <span class="nav-icon"><i class="fas fa-home"></i></span>
        <span>Dashboard</span>
    </a>
</li>
<li class="{{ request()->routeIs('kasir.pesanan.*') ? 'active' : '' }}">
    <a href="{{ route('kasir.pesanan.input') }}">
        <span class="nav-icon"><i class="fas fa-cart-plus"></i></span>
        <span>Input Pesanan</span>
    </a>
</li>
<li class="{{ request()->routeIs('kasir.status.*') ? 'active' : '' }}">
    <a href="{{ route('kasir.status.update') }}">
        <span class="nav-icon"><i class="fas fa-tasks"></i></span>
        <span>Update Status</span>
    </a>
</li>
<li class="{{ request()->routeIs('kasir.pembayaran.*') ? 'active' : '' }}">
    <a href="{{ route('kasir.pembayaran.catat') }}">
        <span class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></span>
        <span>Catat Pembayaran</span>
    </a>
</li>
