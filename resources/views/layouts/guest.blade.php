<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Resume Analyzer') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="font-family:'Outfit',sans-serif;margin:0;padding:0;min-height:100vh;background:#FAF5FF;background-image:radial-gradient(ellipse at top right,rgba(192,132,252,0.2),transparent 50%),radial-gradient(ellipse at bottom left,rgba(124,58,237,0.12),transparent 50%);">
        <div style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 1rem;">

            {{-- Logo --}}
            <a href="/" style="display:flex;flex-direction:column;align-items:center;text-decoration:none;margin-bottom:2rem;">
                <div style="width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 24px rgba(124,58,237,0.3);margin-bottom:0.75rem;">
                    <svg style="width:32px;height:32px;" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <span style="font-size:1.5rem;font-weight:800;color:#1e1b4b;letter-spacing:-0.02em;">Resume<span style="color:#7C3AED;">Analyzer</span></span>
            </a>

            {{-- Card --}}
            <div style="width:100%;max-width:460px;background:white;border-radius:24px;padding:2.5rem;box-shadow:0 20px 60px rgba(124,58,237,0.1);border:1px solid #f0eaff;">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
