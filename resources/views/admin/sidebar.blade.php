<li class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
    <a href="{{ route('dashboard.admin') }}">
        <span class="nav-icon"><i class="fas fa-tachometer-alt"></i></span>
        <span>Dashboard</span>
    </a>
</li>
<li class="{{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
    <a href="{{ route('admin.pesanan.index') }}">
        <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
        <span>Detail Pesanan</span>
    </a>
</li>
<li class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
    <a href="{{ route('admin.employees.index') }}">
        <span class="nav-icon"><i class="fas fa-users"></i></span>
        <span>Kelola Pegawai</span>
    </a>
</li>
<li class="{{ request()->routeIs('admin.penggajian*') ? 'active' : '' }}">
    <a href="{{ route('admin.penggajian.index') }}">
        <span class="nav-icon"><i class="fas fa-money-bill-wave"></i></span>
        <span>Kelola Penggajian</span>
    </a>
</li>
<li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <a href="{{ route('admin.users.index') }}">
        <span class="nav-icon"><i class="fas fa-user-cog"></i></span>
        <span>Manajemen User</span>
    </a>
</li>