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
            *, ::before, ::after { box-sizing: border-box; }
            body { 
                font-family: 'Outfit', sans-serif; 
                margin: 0; 
                padding: 0; 
                min-height: 100vh; 
                background-color: #F8FAFC; 
                color: #0F172A;
            }
            
            /* Chrome/Edge/Safari Autofill Fix to prevent harsh black borders and yellow backgrounds */
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus, 
            input:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0 30px #F8FAFC inset !important;
                -webkit-text-fill-color: #0F172A !important;
                transition: background-color 5000s ease-in-out 0s;
                font-family: 'Outfit', sans-serif !important;
            }
            
            /* Form Control Base Styles */
            .iq-input,
            .iq-select,
            input[type="text"], 
            input[type="email"], 
            input[type="password"], 
            select {
                appearance: none !important;
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                width: 100% !important;
                padding: 0.82rem 1.15rem !important;
                border: 1.5px solid #CBD5E1 !important;
                border-radius: 14px !important;
                background-color: #F8FAFC !important;
                font-family: 'Outfit', sans-serif !important;
                font-size: 0.95rem !important;
                font-weight: 500 !important;
                color: #0F172A !important;
                outline: none !important;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04) !important;
            }

            /* Custom Select Arrow */
            .iq-select, select {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748B'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2.2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") !important;
                background-repeat: no-repeat !important;
                background-position: right 1.1rem center !important;
                background-size: 1.15rem !important;
                padding-right: 2.8rem !important;
            }
            
            /* Form Control Focus State */
            .iq-input:focus, 
            .iq-select:focus,
            input[type="text"]:focus, 
            input[type="email"]:focus, 
            input[type="password"]:focus, 
            select:focus {
                background-color: #FFFFFF !important;
                border-color: #4F46E5 !important;
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.14), 0 2px 8px rgba(79, 70, 229, 0.08) !important;
            }
            
            /* Floating Auth Card Hover */
            .auth-card {
                background: #FFFFFF;
                border-radius: 24px;
                padding: 2.5rem;
                box-shadow: 0 20px 50px -10px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.9);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
        </style>
    </head>
    <body style="font-family:'Outfit',sans-serif;margin:0;padding:0;min-height:100vh;background:#F8FAFC;background-image:radial-gradient(circle at 15% 15%,rgba(99,102,241,0.08) 0%,transparent 45%),radial-gradient(circle at 85% 75%,rgba(168,85,247,0.08) 0%,transparent 45%);">
        <div style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1rem;">

            {{-- Brand Logo Header --}}
            <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;margin-bottom:2rem;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#3B82F6,#4F46E5);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px -4px rgba(79,70,229,0.4);">
                    <svg style="width:26px;height:26px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span style="font-size:1.7rem;font-weight:900;color:#0F172A;letter-spacing:-0.03em;">Resume<span style="color:#4F46E5;">IQ</span></span>
            </a>

            {{-- Auth Form Container --}}
            <div class="auth-card" style="width:100%;max-width:460px;">
                {{ $slot }}
            </div>

            {{-- Footer info --}}
            <div style="margin-top:2rem;text-align:center;font-size:0.82rem;color:#94A3B8;font-weight:500;">
                &copy; {{ date('Y') }} ResumeIQ AI. Built for Smart Hiring &amp; Career Growth.
            </div>

        </div>
    </body>
</html>

