<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Resume Analyzer') }} – @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* --- NAVBAR --- */
        .navbar {
            background: #0f172a;
            color: #e2e8f0;
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .navbar-brand {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: -0.3px;
        }
        .navbar-brand span { color: #3b82f6; }
        .navbar-nav { display: flex; align-items: center; gap: 0.25rem; }
        .nav-link {
            color: #94a3b8;
            text-decoration: none;
            padding: 0.4rem 0.85rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
        }
        .nav-link:hover, .nav-link.active { background: #1e293b; color: #ffffff; }
        .nav-separator { width: 1px; height: 20px; background: #334155; margin: 0 0.5rem; }
        .nav-badge {
            font-size: 0.7rem;
            background: #3b82f6;
            color: white;
            padding: 2px 7px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 0.4rem;
        }
        .nav-badge.hr { background: #10b981; }
        .nav-badge.admin { background: #f59e0b; color: #000; }
        .btn-logout {
            background: #dc2626;
            color: white;
            border: none;
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: #b91c1c; }

        /* --- MAIN WRAPPER --- */
        .page-wrapper { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* --- PAGE HEADER --- */
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.6rem; font-weight: 700; color: #0f172a; }
        .page-header p { color: #64748b; font-size: 0.925rem; margin-top: 0.25rem; }

        /* --- CARDS --- */
        .card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .card-title { font-size: 1rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem; }

        /* --- STATS ROW --- */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.25rem 1.5rem; }
        .stat-number { font-size: 2rem; font-weight: 700; color: #0f172a; }
        .stat-label { font-size: 0.8rem; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 0.25rem; }
        .stat-card.blue .stat-number { color: #2563eb; }
        .stat-card.green .stat-number { color: #059669; }
        .stat-card.amber .stat-number { color: #d97706; }

        /* --- TABLES --- */
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        thead tr { background: #f8fafc; }
        th { text-align: left; padding: 0.75rem 1rem; font-weight: 600; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
        td { padding: 0.85rem 1rem; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
        tr:hover td { background: #f8fafc; }
        tr:last-child td { border-bottom: none; }

        /* --- FORMS --- */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.4rem; }
        .form-control {
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 0.9rem;
            font-family: inherit;
            color: #1e293b;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .form-error { color: #dc2626; font-size: 0.8rem; margin-top: 0.3rem; }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }

        /* --- BUTTONS --- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.2rem;
            border-radius: 7px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
            font-family: inherit;
        }
        .btn-primary { background: #2563eb; color: white; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-success { background: #059669; color: white; }
        .btn-success:hover { background: #047857; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.8rem; }
        .btn-group { display: flex; gap: 0.5rem; align-items: center; }

        /* --- BADGE --- */
        .badge { display: inline-block; padding: 0.25rem 0.65rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-blue { background: #dbeafe; color: #1d4ed8; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-amber { background: #fef3c7; color: #92400e; }
        .badge-gray { background: #f1f5f9; color: #475569; }

        /* --- ALERTS --- */
        .alert { padding: 0.9rem 1.1rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.9rem; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* --- SCORE BAR --- */
        .score-bar-wrapper { background: #e2e8f0; border-radius: 20px; height: 8px; min-width: 120px; }
        .score-bar { height: 8px; border-radius: 20px; background: linear-gradient(to right, #3b82f6, #2563eb); }

        /* --- MISC --- */
        .text-muted { color: #94a3b8; font-size: 0.85rem; }
        .mt-1 { margin-top: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .gap-2 { gap: 0.75rem; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        @media (max-width: 640px) { .grid-2 { grid-template-columns: 1fr; } }
        .empty-state { text-align: center; padding: 3rem; color: #94a3b8; }
        .empty-state h3 { font-size: 1rem; color: #64748b; margin-bottom: 0.5rem; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Resume<span>Analyzer</span></a>
    <div class="navbar-nav">
        @auth
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
                <a href="{{ route('jobs.index') }}" class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}">Job Postings</a>
                <a href="{{ route('candidates.index') }}" class="nav-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}">Candidates</a>
            @else
                <a href="{{ route('jobs.index') }}" class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}">Browse Jobs</a>
                <a href="{{ route('candidates.my') }}" class="nav-link {{ request()->routeIs('candidates.my') ? 'active' : '' }}">My Applications</a>
            @endif
            <div class="nav-separator"></div>
            <span class="text-muted" style="font-size:0.875rem;">{{ auth()->user()->name }}
                @if(auth()->user()->role === 'hr')
                    <span class="nav-badge hr">HR</span>
                @elseif(auth()->user()->role === 'admin')
                    <span class="nav-badge admin">Admin</span>
                @else
                    <span class="nav-badge">Candidate</span>
                @endif
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @endauth
    </div>
</nav>

<div class="page-wrapper">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

@stack('scripts')
</body>
</html>
