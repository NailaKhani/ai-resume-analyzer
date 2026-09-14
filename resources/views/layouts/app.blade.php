<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ResumeIQ AI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

        <!-- Alpine.js CDN to guarantee 100% interactive dropdown & modal clicks -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts & Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; }
            [x-cloak] { display: none !important; }
            body { font-family: 'Outfit', sans-serif; background-color: #F8FAFC; color: #0F172A; }
            .app-container { max-width: 1280px; margin: 0 auto; padding-left: 2rem; padding-right: 2rem; }
            
            /* Glass card utility */
            .glass-card {
                background: #FFFFFF;
                border: 1px solid #E2E8F0;
                border-radius: 20px;
                box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
                transition: all 0.3s ease;
            }
            .glass-card:hover {
                box-shadow: 0 12px 30px -10px rgba(79, 70, 229, 0.12);
                border-color: #C7D2FE;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-color: #F8FAFC; color: #0F172A; min-height: 100vh;">
        <div style="min-height: 100vh;">
            <!-- Navigation Header -->
            <nav style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(16px); border-bottom: 1px solid #E2E8F0; position: sticky; top: 0; z-index: 50; width: 100%;">
                <div class="app-container" style="display: flex; justify-content: space-between; align-items: center; height: 70px;">
                    
                    <div style="display: flex; align-items: center; gap: 2.5rem;">
                        <!-- Logo -->
                        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #3B82F6, #4F46E5); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);">
                                <svg style="width: 22px; height: 22px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span style="font-size: 1.35rem; font-weight: 900; color: #0F172A; letter-spacing: -0.03em;">Resume<span style="color: #4F46E5;">IQ</span></span>
                        </a>

                        <!-- Navigation Items -->
                        <div style="display: flex; gap: 1.5rem; align-items: center;">
                            <a href="{{ route('dashboard') }}" style="font-size: 0.92rem; font-weight: 700; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px; transition: color 0.2s;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Dashboard</a>
                            
                            @if(Auth::user()->role === 'hr')
                                <a href="{{ route('jobs.index') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Jobs Management</a>
                                <a href="{{ route('candidates.index') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Candidates Pool</a>
                            @endif
                            
                            @if(Auth::user()->role === 'candidate')
                                <a href="{{ route('candidates.index') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Browse Jobs</a>
                                <a href="{{ route('candidates.my') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">My Applications</a>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Admin Overview</a>
                                <a href="{{ route('admin.users') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">User Management</a>
                                <a href="{{ route('admin.activity') }}" style="font-size: 0.92rem; font-weight: 600; color: #475569; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 8px;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Activity Log</a>
                            @endif
                        </div>
                    </div>

                    <!-- User Actions: Direct Profile Link & Dropdown -->
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        
                        <!-- Direct Clickable Profile Link -->
                        <a href="{{ route('profile.edit') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 50px; background: #EEF2FF; border: 1px solid #C7D2FE; color: #4F46E5; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#E0E7FF'" onmouseout="this.style.background='#EEF2FF'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profile
                        </a>

                        <!-- User Info Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button type="button" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 1.1rem; border: 1.5px solid #E2E8F0; border-radius: 50px; background: white; font-size: 0.88rem; font-weight: 700; color: #0F172A; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.03); transition: all 0.2s;" onmouseover="this.style.borderColor='#4F46E5'">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10B981;"></span>
                                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                                    <svg style="width:14px;height:14px;fill:#64748B;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile Settings') }}</x-dropdown-link>
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
                <header style="background: white; border-bottom: 1px solid #E2E8F0; margin: 1.5rem 0 0 0;">
                    <div class="app-container" style="padding-top: 1.25rem; padding-bottom: 1.25rem;">
                        {{ $header ?? '' }}
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="app-container" style="padding-top: 2.2rem; padding-bottom: 3rem;">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </body>
</html>
