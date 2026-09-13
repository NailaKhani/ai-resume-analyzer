<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Resume Analyzer') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .app-container { width: 100%; padding-left: 2rem; padding-right: 2rem; }
            @media (min-width: 1024px) { .app-container { padding-left: 3rem; padding-right: 3rem; } }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-color: #FAF5FF; color: #1E1B4B; min-height: 100vh;">
        <div style="min-height: 100vh;">
            <!-- Navigation -->
            <nav style="background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #ede9fe; box-shadow: 0 1px 4px rgba(124,58,237,0.06); position: sticky; top: 0; z-index: 50; width: 100%;">
                <div class="app-container" style="display: flex; justify-content: space-between; align-items: center; height: 64px;">
                    <div style="display: flex; align-items: center; gap: 2.5rem;">
                        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 0.6rem; text-decoration: none;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #7C3AED, #C084FC); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(124,58,237,0.3);">
                                <svg style="width:22px;height:22px;color:white;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <span style="font-size: 1.2rem; font-weight: 800; color: #1e1b4b; letter-spacing: -0.02em;">Resume<span style="color: #7C3AED;">Analyzer</span></span>
                        </a>

                        <div style="display: flex; gap: 1.5rem; align-items: center;">
                            <a href="{{ route('dashboard') }}" style="font-size: 0.875rem; font-weight: 600; color: #7C3AED; text-decoration: none; border-bottom: 2px solid #7C3AED; padding-bottom: 2px;">Dashboard</a>
                            @if(Auth::user()->role === 'hr')
                                <a href="{{ route('jobs.index') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">Jobs</a>
                                <a href="{{ route('candidates.index') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">Candidates</a>
                            @endif
                            @if(Auth::user()->role === 'candidate')
                                <a href="{{ route('candidates.index') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">Browse Jobs</a>
                                <a href="{{ route('candidates.my') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">My Applications</a>
                            @endif
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">Admin Panel</a>
                                <a href="{{ route('admin.users') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">Users</a>
                                <a href="{{ route('admin.activity') }}" style="font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none;" onmouseover="this.style.color='#7C3AED'" onmouseout="this.style.color='#64748b'">Activity</a>
                            @endif
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div style="display: flex; align-items: center;">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button style="display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white; font-size: 0.85rem; font-weight: 600; color: #475569; cursor: pointer;">
                                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                                    <svg style="width:14px;height:14px;fill:#94a3b8;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @if(isset($header) || View::hasSection('header'))
                <header style="background: rgba(255,255,255,0.5); backdrop-filter: blur(8px); border-bottom: 1px solid #ede9fe; margin: 1.5rem 2rem 0; border-radius: 12px;">
                    <div class="app-container" style="padding-top: 1.25rem; padding-bottom: 1.25rem;">
                        {{ $header ?? '' }}
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="app-container" style="padding-top: 2rem; padding-bottom: 2rem;">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </body>
</html>
