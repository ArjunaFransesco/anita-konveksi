<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Anita Konveksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1A1A1A;
            --accent: #FF9F1C;
            --accent-dark: #e68a00;
            --accent-light: rgba(255, 159, 28, 0.12);
            --sidebar-width: 260px;
            --bg-main: #F8F9FA;
            --bg-card: #FFFFFF;
            --text-main: #2D2D2D;
            --text-muted: #6C757D;
            --text-light: #ADB5BD;
            --border: #E9ECEF;
            --shadow-sm: 0 1px 4px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            display: flex;
            height: 100vh;
            overflow: hidden;
            color: var(--text-main);
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            position: relative;
            z-index: 100;
            overflow: hidden;
        }

        /* Decorative accent line at top */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--accent);
        }

        .sidebar-brand {
            padding: 1.5rem 1.4rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 0.8rem;
        }

        .sidebar-brand .brand-icon {
            width: 38px;
            height: 38px;
            background: var(--accent);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--primary);
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-name {
            line-height: 1.2;
        }

        .sidebar-brand .brand-name h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: #FFFFFF;
            letter-spacing: 0.01em;
        }

        .sidebar-brand .brand-name span {
            font-size: 0.72rem;
            color: var(--accent);
            font-weight: 500;
        }

        .sidebar-brand .system-badge {
            display: inline-block;
            background: rgba(255,159,28,0.15);
            color: var(--accent);
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* User Profile */
        .sidebar-user {
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .user-details .user-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #FFFFFF;
            line-height: 1.2;
        }

        .user-details .user-role {
            font-size: 0.72rem;
            color: var(--accent);
            font-weight: 500;
            text-transform: capitalize;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar { width: 0; }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 0.6rem 1.4rem 0.4rem;
        }

        .sidebar-nav ul { list-style: none; padding: 0 0.8rem; }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 2px;
            position: relative;
        }

        .sidebar-nav li a .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .sidebar-nav li a:hover {
            background: rgba(255,159,28,0.12);
            color: var(--accent);
        }

        .sidebar-nav li.active a {
            background: var(--accent);
            color: var(--primary);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255,159,28,0.35);
        }

        .sidebar-nav li.active a .nav-icon {
            color: var(--primary);
        }

        /* Logout */
        .sidebar-footer {
            padding: 1rem 0.8rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #FF6B6B;
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            background: rgba(255,107,107,0.08);
        }

        .logout-btn:hover {
            background: rgba(255,107,107,0.18);
            color: #FF4D4D;
        }

        /* ─── MAIN CONTENT ─── */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top Bar */
        .topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .topbar-left {
            display: flex;
            flex-direction: column;
        }

        .topbar-left .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
        }

        .topbar-left .page-subtitle {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 6px 14px 6px 8px;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .topbar-badge .avatar {
            width: 28px;
            height: 28px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: var(--primary);
        }

        .topbar-badge .badge-role {
            font-size: 0.7rem;
            background: var(--accent-light);
            color: var(--accent-dark);
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 1.75rem 2rem;
        }

        .content-area::-webkit-scrollbar { width: 6px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* ─── INNER CONTENT COMPONENTS ─── */
        .section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-header h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
        }

        .section-header p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 4px; height: 100%;
        }

        .stat-card.orange::after { background: var(--accent); }
        .stat-card.dark::after   { background: var(--primary); }
        .stat-card.green::after  { background: #28a745; }
        .stat-card.blue::after   { background: #007bff; }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 0.9rem;
        }

        .stat-card.orange .stat-icon { background: var(--accent-light); color: var(--accent); }
        .stat-card.dark .stat-icon   { background: rgba(26,26,26,0.08); color: var(--primary); }
        .stat-card.green .stat-icon  { background: rgba(40,167,69,0.1); color: #28a745; }
        .stat-card.blue .stat-icon   { background: rgba(0,123,255,0.1); color: #007bff; }

        .stat-card .stat-value {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .stat-card .stat-delta {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .delta-up   { background: rgba(40,167,69,0.1); color: #28a745; }
        .delta-down { background: rgba(220,53,69,0.1); color: #dc3545; }

        /* Grid 2-col for cards */
        .cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .content-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.25rem 0.9rem;
            border-bottom: 1px solid var(--border);
        }

        .card-header h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--primary);
        }

        .card-header .card-badge {
            font-size: 0.72rem;
            background: var(--accent-light);
            color: var(--accent-dark);
            padding: 3px 9px;
            border-radius: 20px;
            font-weight: 600;
        }

        .card-body { padding: 1.1rem 1.25rem; }

        /* Table style */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .data-table thead tr {
            background: var(--primary);
        }

        .data-table thead th {
            padding: 11px 14px;
            text-align: left;
            font-size: 0.78rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .data-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: var(--bg-main); }

        .data-table tbody td {
            padding: 11px 14px;
            color: var(--text-main);
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-success { background: rgba(40,167,69,0.12); color: #28a745; }
        .badge-warning { background: rgba(255,159,28,0.15); color: #cc7a00; }
        .badge-danger  { background: rgba(220,53,69,0.12); color: #dc3545; }
        .badge-info    { background: rgba(0,123,255,0.1); color: #007bff; }
        .badge-dark    { background: rgba(26,26,26,0.1); color: var(--primary); }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--primary);
            box-shadow: 0 3px 10px rgba(255,159,28,0.3);
        }
        .btn-primary:hover {
            box-shadow: 0 6px 18px rgba(255,159,28,0.45);
            transform: translateY(-1px);
            color: var(--primary);
        }

        .btn-dark {
            background: var(--primary);
            color: #fff;
        }
        .btn-dark:hover { background: #333; color: #fff; }

        .btn-outline {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }
        .btn-outline:hover {
            background: var(--bg-main);
            color: var(--text-main);
        }

        .btn-sm { padding: 5px 11px; font-size: 0.75rem; }
        .btn-danger { background: rgba(220,53,69,0.1); color: #dc3545; border: 1px solid rgba(220,53,69,0.2); }
        .btn-danger:hover { background: rgba(220,53,69,0.2); }

        /* Form elements */
        .form-select, .form-input {
            padding: 7px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-family: 'Inter', sans-serif;
            background: var(--bg-card);
            color: var(--text-main);
            transition: border-color 0.2s;
        }
        .form-select:focus, .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255,159,28,0.12);
        }

        /* Alert */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success { background: rgba(40,167,69,0.1); color: #155724; border-left: 3px solid #28a745; }
        .alert-danger  { background: rgba(220,53,69,0.1); color: #721c24; border-left: 3px solid #dc3545; }

        /* Action buttons in table */
        .action-group { display: flex; align-items: center; gap: 6px; }

        /* Filter bar */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1rem 1.25rem;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 2.5rem; opacity: 0.3; margin-bottom: 0.75rem; }
        .empty-state p { font-size: 0.9rem; }

        /* Penggajian list items */
        .payroll-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .payroll-item:last-child { border-bottom: none; padding-bottom: 0; }
        .payroll-item .pi-left { display: flex; align-items: center; gap: 10px; }
        .payroll-item .pi-avatar {
            width: 34px; height: 34px;
            background: var(--accent-light);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; color: var(--accent-dark); font-weight: 700;
        }
        .payroll-item .pi-name { font-size: 0.85rem; font-weight: 600; color: var(--primary); }
        .payroll-item .pi-position { font-size: 0.75rem; color: var(--text-muted); }
        .payroll-item .pi-amount { font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 700; color: var(--primary); }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .cards-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 68px; }
            .sidebar-brand .brand-name,
            .sidebar-brand .system-badge,
            .sidebar-user .user-details,
            .sidebar-nav li a span,
            .sidebar-footer .logout-text,
            .nav-section-label { display: none; }
            .sidebar-brand .brand-icon { margin: 0 auto; }
            .sidebar-brand .brand-logo { justify-content: center; }
            .sidebar-brand { padding: 1.2rem 0.8rem; }
            .sidebar-user { justify-content: center; padding: 1rem 0.5rem; }
            .sidebar-nav li a { justify-content: center; padding: 12px; gap: 0; }
            .sidebar-nav ul { padding: 0 0.4rem; }
            .logout-btn { justify-content: center; padding: 12px; }
            .content-area { padding: 1.25rem; }
            .topbar { padding: 0 1.25rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}" class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-icon" style="background: transparent; border-radius: 0; width: 40px; height: 40px; object-fit: contain;">
                <div class="brand-name">
                    <h2>Anita Konveksi</h2>
                    <span>& Sablon</span>
                </div>
            </a>
            <span class="system-badge">Sistem Informasi</span>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>
            <ul>
                @yield('sidebar-menu')
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" class="logout-btn" onclick="this.closest('form').submit(); return false;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="logout-text">Logout</span>
                </a>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main-wrapper">
        <div class="topbar">
            <div class="topbar-left">
                <span class="page-title">@yield('page-title')</span>
                <span class="page-subtitle">@yield('page-subtitle', 'Anita Konveksi Admin Panel')</span>
            </div>
            <div class="topbar-right">
                <div class="topbar-badge">
                    <div class="avatar"><i class="fas fa-user"></i></div>
                    <span>{{ Auth::user()->name }}</span>
                    <span class="badge-role">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            @yield('dashboard-content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>