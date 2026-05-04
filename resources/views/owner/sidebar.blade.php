<li class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
    <a href="{{ route('owner.dashboard') }}">
        <span class="nav-icon"><i class="fas fa-home"></i></span>
        <span>Dashboard</span>
    </a>
</li>
<li class="{{ request()->routeIs('owner.transaksi') ? 'active' : '' }}">
    <a href="{{ route('owner.transaksi') }}">
        <span class="nav-icon"><i class="fas fa-exchange-alt"></i></span>
        <span>Transaksi</span>
    </a>
</li>
<li class="{{ request()->routeIs('owner.laporan') ? 'active' : '' }}">
    <a href="{{ route('owner.laporan') }}">
        <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
        <span>Laporan</span>
    </a>
</li>
<li class="{{ request()->routeIs('owner.piutang') ? 'active' : '' }}">
    <a href="{{ route('owner.piutang') }}">
        <span class="nav-icon"><i class="fas fa-hand-holding-usd"></i></span>
        <span>Piutang</span>
    </a>
</li>
<li class="{{ request()->routeIs('owner.monitoring') ? 'active' : '' }}">
    <a href="{{ route('owner.monitoring') }}">
        <span class="nav-icon"><i class="fas fa-industry"></i></span>
        <span>Monitoring Produksi</span>
    </a>
</li>
