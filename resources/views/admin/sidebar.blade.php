<li class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
    <a href="{{ route('dashboard.admin') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
</li>
<li><a href="#"><i class="fas fa-shopping-cart"></i> <span>Kelola Pesanan</span></a></li>
<li class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
    <a href="{{ route('admin.employees.index') }}"><i class="fas fa-users"></i> <span>Kelola Pegawai</span></a>
</li>
<li><a href="#"><i class="fas fa-money-bill-wave"></i> <span>Kelola Penggajian</span></a></li>
<li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> <span>Manajemen User</span></a>
</li>