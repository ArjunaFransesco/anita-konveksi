<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Anita Konveksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; display: flex; height: 100vh; overflow: hidden; }
        
        /* SIDEBAR */
        .sidebar {
            width: 280px;
            background: #1A1A1A;
            color: #ccc;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header h2 {
            color: white;
            font-size: 1.3rem;
        }
        .sidebar-header span {
            color: #FF9F1C;
        }
        .sidebar-menu {
            flex: 1;
            padding: 1.5rem 0;
        }
        .sidebar-menu ul {
            list-style: none;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        .sidebar-menu li a i {
            width: 22px;
            font-size: 1.1rem;
        }
        .sidebar-menu li a:hover {
            background: rgba(255,159,28,0.2);
            color: #FF9F1C;
        }
        .sidebar-menu li.active a {
            background: #FF9F1C;
            color: #1A1A1A;
            font-weight: 500;
        }
        .logout-btn {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 1rem 0;
        }
        .logout-btn a {
            color: #ff6b6b;
        }
        .logout-btn a:hover {
            background: rgba(255,107,107,0.2);
            color: #ff6b6b;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 2rem;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        .page-title h1 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #1A1A1A;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 6px 15px;
            border-radius: 40px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .user-info span {
            font-weight: 500;
        }
        .user-info i {
            font-size: 1.2rem;
            color: #FF9F1C;
        }
        .content-wrapper {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .sidebar { width: 80px; }
            .sidebar-header h2, .sidebar-header span { display: none; }
            .sidebar-menu li a span { display: none; }
            .sidebar-menu li a i { margin: 0 auto; }
            .sidebar-menu li a { justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Anita <span>Konveksi</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                @yield('sidebar-menu')
            </ul>
        </div>
        <div class="sidebar-menu logout-btn">
            <ul>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <a href="#" onclick="this.closest('form').submit(); return false;">
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>@yield('page-title')</h1>
            </div>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name }}</span>
                <span style="font-size:0.8rem; background:#f0f0f0; padding:2px 8px; border-radius:20px;">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
        <div class="content-wrapper">
            @yield('dashboard-content')
        </div>
    </div>
</body>
</html>