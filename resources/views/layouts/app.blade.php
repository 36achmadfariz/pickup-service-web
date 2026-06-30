<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Instant Pickup') — Kantor Pos Cilegon 42400</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #E84C16; --primary-hover: #C54012;
            --primary-light: #3D1A0A; --navy: #0B1120;
            --navy-card: #111827; --navy-light: #1E293B;
            --navy-lighter: #334155; --surface: #111827;
            --bg: #0B1120; --text: #F1F5F9;
            --text-muted: #94A3B8; --text-dim: #64748B;
            --border: #1E293B; --border-light: #334155;
            --shadow-sm: 0px 0px 0px 1px rgba(255,255,255,0.05), 0px 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0px 0px 0px 1px rgba(255,255,255,0.06), 0px 4px 12px rgba(0,0,0,0.4);
            --radius: 14px; --radius-sm: 8px; --radius-pill: 9999px;
            --success: #10B981; --warning: #F59E0B; --info: #3B82F6; --danger: #EF4444;
            --whatsapp: #25D366;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; -webkit-font-smoothing: antialiased; }

        /* ===== DASHBOARD LAYOUT ===== */
        .dashboard-layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px; background: linear-gradient(180deg, #0A0F1A 0%, #070B14 100%);
            color: #fff; padding: 1.5rem; display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
            border-right: 1px solid var(--border);
        }
        .sidebar-brand { font-size: 1.1rem; font-weight: 800; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-brand span { background: var(--primary); padding: 0.2rem 0.5rem; border-radius: 5px; font-size: 0.6rem; text-transform: uppercase; }
        .sidebar-nav { list-style: none; flex: 1; }
        .sidebar-nav li { margin-bottom: 0.2rem; }
        .sidebar-nav a {
            color: var(--text-muted); text-decoration: none; padding: 0.6rem 0.8rem;
            display: flex; align-items: center; gap: 0.6rem; border-radius: 8px;
            font-size: 0.88rem; font-weight: 500; transition: all 0.2s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(232,76,22,0.15); color: #fff; }
        .sidebar-footer { margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border); font-size: 0.8rem; }
        .sidebar-footer .user-name { color: var(--text-muted); margin-bottom: 0.5rem; }
        .sidebar-footer button {
            background: rgba(239,68,68,0.15); color: #FCA5A5; border: none;
            padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;
            width: 100%; font-size: 0.85rem; font-weight: 600; font-family: inherit;
        }
        .sidebar-footer button:hover { background: rgba(239,68,68,0.25); }

        .main-content { margin-left: 250px; flex: 1; padding: 1.5rem 2rem; background: var(--bg); }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .topbar h1 { font-size: 1.3rem; font-weight: 700; color: #fff; }
        .topbar .user-badge {
            display: flex; align-items: center; gap: 0.6rem;
            background: var(--surface); padding: 0.4rem 1rem; border-radius: var(--radius-pill);
            box-shadow: var(--shadow-sm); font-size: 0.85rem; font-weight: 600; border: 1px solid var(--border-light);
        }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; }

        /* Cards */
        .card { background: var(--surface); border-radius: var(--radius); padding: 1.3rem; border: 1px solid var(--border-light); margin-bottom: 1.2rem; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .card-header h2, .card-header h3 { font-size: 1.05rem; font-weight: 700; color: #fff; }

        .dash-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 0.8rem; margin-bottom: 1.2rem; }

        /* Stat card */
        .stat-card {
            background: var(--surface); border-radius: var(--radius); padding: 1.2rem 1.4rem;
            border: 1px solid var(--border-light); display: flex; align-items: center; gap: 1rem;
            transition: transform 0.2s; position: relative; overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .accent-bar { position: absolute; left: 0; top: 0; bottom: 0; width: 4px; }
        .stat-card .stat-icon { width: 44px; height: 44px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .stat-card .stat-num { font-size: 1.6rem; font-weight: 800; line-height: 1; color: #fff; }
        .stat-card .stat-label { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; }

        /* Forms */
        .form-group { margin-bottom: 0.9rem; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.82rem; color: var(--text-muted); }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid var(--border-light);
            border-radius: var(--radius-sm); font-size: 0.88rem; font-family: inherit;
            background: var(--bg); color: var(--text); transition: all 0.2s;
        }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(232,76,22,0.15);
        }
        .form-group input::placeholder, .form-group textarea::placeholder { color: var(--text-dim); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.4rem; border: none; border-radius: var(--radius-sm); cursor: pointer; font-size: 0.88rem; font-weight: 600; font-family: inherit; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background: var(--primary); color: #fff; } .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); }
        .btn-success { background: var(--success); color: #fff; } .btn-success:hover { filter: brightness(1.1); }
        .btn-danger { background: var(--danger); color: #fff; } .btn-danger:hover { filter: brightness(1.1); }
        .btn-sm { padding: 0.35rem 0.9rem; font-size: 0.78rem; border-radius: 6px; }
        .btn-outline-sm { background: transparent; border: 1.5px solid var(--border-light); color: var(--text-muted); padding: 0.35rem 0.9rem; border-radius: 6px; font-size: 0.78rem; font-weight: 600; cursor: pointer; font-family: inherit; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; }
        .btn-outline-sm:hover { border-color: var(--primary); color: var(--primary); }

        .alert { padding: 0.8rem 1.1rem; border-radius: var(--radius-sm); margin-bottom: 1rem; font-size: 0.88rem; font-weight: 500; }
        .alert-success { background: rgba(16,185,129,0.1); color: #34D399; border: 1px solid rgba(16,185,129,0.3); }
        .alert-error { background: rgba(239,68,68,0.1); color: #FCA5A5; border: 1px solid rgba(239,68,68,0.3); }

        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.86rem; }
        th { background: var(--bg); font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-dim); padding: 0.8rem 0.7rem; text-align: left; border-bottom: 1px solid var(--border); }
        td { padding: 0.7rem 0.7rem; border-bottom: 1px solid var(--border); vertical-align: middle; color: var(--text-muted); }
        tr:hover td { background: rgba(255,255,255,0.02); }
        td:first-child { color: #fff; font-weight: 600; }

        /* Badges */
        .badge { display: inline-block; padding: 0.2rem 0.7rem; border-radius: var(--radius-pill); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; }
        .badge-menunggu { background: rgba(245,158,11,0.12); color: #FBBF24; }
        .badge-diproses, .badge-dalam_perjalanan { background: rgba(59,130,246,0.12); color: #60A5FA; }
        .badge-selesai { background: rgba(16,185,129,0.12); color: #34D399; }

        .search-bar { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
        .search-bar input { flex: 1; padding: 0.6rem 1rem; border: 1.5px solid var(--border-light); border-radius: var(--radius-pill); font-size: 0.88rem; font-family: inherit; background: var(--bg); color: var(--text); }
        .search-bar input:focus { border-color: var(--primary); outline: none; }
        .search-bar input::placeholder { color: var(--text-dim); }

        /* Login form */
        .form-page { max-width: 460px; margin: 5rem auto; padding: 0 1.5rem; }
        .form-card {
            background: var(--surface); border-radius: var(--radius);
            padding: 2.5rem 2rem; border: 1px solid var(--border-light);
        }
        .form-card .form-header { text-align: center; margin-bottom: 2rem; }
        .form-card .form-header h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 0.3rem; }
        .form-card .form-header p { color: var(--text-muted); font-size: 0.9rem; }
        .form-card .form-group label { color: var(--text-muted); }
        .form-card .btn { width: 100%; justify-content: center; padding: 0.8rem; font-size: 1rem; border-radius: 50px; }

        @media (max-width: 768px) {
            .sidebar { width: 200px; padding: 1rem; }
            .main-content { margin-left: 200px; padding: 1rem; }
            .form-row { grid-template-columns: 1fr; }
            .dash-stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

@auth
<div class="dashboard-layout">
    <aside class="sidebar">
        <div class="sidebar-brand">📦 Pickup<span>v2.0</span></div>
        <ul class="sidebar-nav">
            @if(auth()->user()->isAdmin())
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a></li>
                <li><a href="{{ route('admin.kurir') }}" class="{{ request()->routeIs('admin.kurir') ? 'active' : '' }}">🛵 Kurir</a></li>
                <li><a href="{{ route('admin.riwayat') }}" class="{{ request()->routeIs('admin.riwayat') ? 'active' : '' }}">📋 Riwayat</a></li>
            @else
                <li><a href="{{ route('kurir.dashboard') }}" class="{{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}">🛵 Tugas Saya</a></li>
                <li><a href="{{ route('kurir.riwayat') }}" class="{{ request()->routeIs('kurir.riwayat') ? 'active' : '' }}">📋 Riwayat</a></li>
            @endif
        </ul>
        <div class="sidebar-footer">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
    </aside>
    <main class="main-content">
        <div class="topbar">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="user-badge">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                {{ auth()->user()->name }}
            </div>
        </div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif
        @yield('content')
    </main>
</div>

@else
{{-- PUBLIC PAGES — no nav, standalone --}}
@if(session('success'))<div style="max-width:1200px;margin:1rem auto;padding:0 1.5rem;"><div class="alert alert-success">{{ session('success') }}</div></div>@endif
@if(session('error'))<div style="max-width:1200px;margin:1rem auto;padding:0 1.5rem;"><div class="alert alert-error">{{ session('error') }}</div></div>@endif
@if($errors->any())
    <div style="max-width:1200px;margin:1rem auto;padding:0 1.5rem;">
        <div class="alert alert-error">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    </div>
@endif
@yield('content')
@endauth

</body>
</html>
