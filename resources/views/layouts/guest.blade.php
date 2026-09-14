<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ResumeIQ AI') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * { box-sizing: border-box; }
            body { font-family: 'Outfit', sans-serif; margin: 0; padding: 0; min-height: 100vh; background: #F8FAFC; }
        </style>
    </head>
    <body style="font-family:'Outfit',sans-serif;margin:0;padding:0;min-height:100vh;background:#F8FAFC;background-image:radial-gradient(circle at 20% 20%,rgba(99,102,241,0.08) 0%,transparent 50%),radial-gradient(circle at 80% 60%,rgba(168,85,247,0.08) 0%,transparent 50%);">
        <div style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 1rem;">

            {{-- Brand Logo --}}
            <a href="/" style="display:flex;align-items:center;gap:10px;text-decoration:none;margin-bottom:2rem;">
                <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#3B82F6,#4F46E5);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(59,130,246,0.35);">
                    <svg style="width:26px;height:26px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span style="font-size:1.6rem;font-weight:900;color:#0F172A;letter-spacing:-0.03em;">Resume<span style="color:#4F46E5;">IQ</span></span>
            </a>

            {{-- Auth Form Card --}}
            <div style="width:100%;max-width:480px;background:white;border-radius:24px;padding:2.5rem;box-shadow:0 20px 50px -10px rgba(15,23,42,0.1);border:1px solid #E2E8F0;">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
