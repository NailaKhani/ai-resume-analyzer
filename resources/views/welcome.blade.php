<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Analyzer AI — Hire Smarter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; background: #FAF5FF; font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .page-wrap { width: 100%; padding-left: 4rem; padding-right: 4rem; }
        @media (max-width: 1024px) { .page-wrap { padding-left: 2rem; padding-right: 2rem; } }
        @keyframes floatBounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav style="position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(255,255,255,0.85);backdrop-filter:blur(16px);border-bottom:1px solid #ede9fe;box-shadow:0 1px 8px rgba(124,58,237,0.07);">
        <div class="page-wrap" style="display:flex;justify-content:space-between;align-items:center;height:72px;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(124,58,237,0.35);">
                    <svg style="width:26px;height:26px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <span style="font-size:1.4rem;font-weight:800;color:#1e1b4b;letter-spacing:-0.02em;">Resume<span style="color:#7C3AED;">Analyzer</span></span>
            </div>
            <div style="display:flex;align-items:center;gap:1.5rem;">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" style="display:inline-flex;align-items:center;padding:0.6rem 1.5rem;border-radius:50px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;text-decoration:none;font-size:0.9rem;box-shadow:0 4px 14px rgba(124,58,237,0.35);">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="color:#475569;font-weight:600;font-size:0.9rem;text-decoration:none;">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;padding:0.6rem 1.5rem;border-radius:50px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;text-decoration:none;font-size:0.9rem;box-shadow:0 4px 14px rgba(124,58,237,0.35);">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section style="width:100%;min-height:100vh;padding-top:100px;padding-bottom:60px;position:relative;overflow:hidden;">
        <!-- Background glow -->
        <div style="position:absolute;top:-100px;left:50%;transform:translateX(-50%);width:80%;height:700px;background:radial-gradient(ellipse,rgba(167,139,250,0.25) 0%,transparent 70%);pointer-events:none;"></div>

        <div class="page-wrap" style="display:flex;flex-direction:row;align-items:center;justify-content:space-between;gap:4rem;min-height:calc(100vh - 160px);">
            
            <!-- Left: Text -->
            <div style="flex:0 0 44%;max-width:44%;">
                <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:50px;background:#ede9fe;border:1px solid #ddd6fe;margin-bottom:1.5rem;">
                    <span style="width:10px;height:10px;border-radius:50%;background:#7C3AED;animation:ping 1.5s infinite;display:inline-block;"></span>
                    <span style="font-size:0.85rem;font-weight:600;color:#7C3AED;">AI-Powered Hiring Platform</span>
                </div>
                <h1 style="font-size:clamp(2.5rem,4.5vw,4.5rem);font-weight:900;color:#1e1b4b;line-height:1.1;margin:0 0 1.25rem 0;letter-spacing:-0.02em;">
                    Hire smarter<br>with <span style="background:linear-gradient(135deg,#7C3AED,#C084FC);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">AI Insights.</span>
                </h1>
                <p style="font-size:1.1rem;color:#475569;line-height:1.75;margin:0 0 2rem 0;">
                    Our intelligent system analyzes resumes against job descriptions in seconds, giving you an accurate Match Score using advanced NLP. Say goodbye to manual screening.
                </p>
                <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                    <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.9rem 2rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;font-size:1rem;text-decoration:none;box-shadow:0 8px 24px rgba(124,58,237,0.3);">
                        Start Analyzing Free
                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="#features" style="display:inline-flex;align-items:center;padding:0.9rem 2rem;border-radius:12px;background:white;border:1.5px solid #e2e8f0;color:#334155;font-weight:700;font-size:1rem;text-decoration:none;">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Right: Image -->
            <div style="flex:0 0 52%;max-width:52%;position:relative;">
                <div style="position:absolute;inset:-20px;background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(192,132,252,0.15));border-radius:2.5rem;transform:rotate(2deg);filter:blur(20px);"></div>
                <div style="position:relative;background:white;padding:12px;border-radius:2.5rem;box-shadow:0 32px 80px rgba(124,58,237,0.15);border:1.5px solid rgba(255,255,255,0.8);">
                    <img src="{{ asset('images/hero.jpg') }}" alt="AI Resume Analysis" style="width:100%;border-radius:2rem;display:block;object-fit:cover;aspect-ratio:16/10;">
                    
                    <!-- Floating badge -->
                    <div style="position:absolute;bottom:-20px;left:-20px;background:white;padding:1rem 1.5rem;border-radius:20px;box-shadow:0 8px 32px rgba(0,0,0,0.12);display:flex;align-items:center;gap:0.8rem;animation:floatBounce 3s ease-in-out infinite;">
                        <div style="width:48px;height:48px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:24px;height:24px;color:#059669;" fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p style="margin:0;font-size:0.75rem;color:#94a3b8;font-weight:600;">Match Score</p>
                            <p style="margin:0;font-size:1.5rem;font-weight:900;color:#1e1b4b;">94.2%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" style="width:100%;padding:80px 0;background:white;">
        <div class="page-wrap">
            <div style="text-align:center;margin-bottom:4rem;">
                <h2 style="font-size:2.5rem;font-weight:800;color:#1e1b4b;margin:0 0 1rem;">Why Choose Resume Analyzer?</h2>
                <p style="font-size:1.1rem;color:#64748b;max-width:600px;margin:0 auto;">Our platform combines cutting-edge AI with an intuitive experience to streamline your hiring workflow.</p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;">
                <!-- Card 1 -->
                <div style="background:#faf5ff;border:1px solid #ede9fe;border-radius:20px;padding:2rem;transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width:56px;height:56px;background:#ede9fe;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg style="width:28px;height:28px;color:#7C3AED;" fill="none" stroke="#7C3AED" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 style="font-size:1.2rem;font-weight:700;color:#1e1b4b;margin:0 0 0.75rem;">Smart Skill Extraction</h3>
                    <p style="color:#64748b;line-height:1.7;margin:0;">Our AI reads PDF and DOCX files to automatically extract core skills, mapping them directly to your job requirements.</p>
                </div>

                <!-- Card 2 -->
                <div style="background:linear-gradient(135deg,#faf5ff,#f3e8ff);border:1px solid #ddd6fe;border-radius:20px;padding:2rem;position:relative;overflow:hidden;box-shadow:0 8px 32px rgba(124,58,237,0.08);transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:rgba(124,58,237,0.08);border-radius:50%;"></div>
                    <div style="width:56px;height:56px;background:#f5d0fe;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;position:relative;z-index:1;">
                        <svg style="width:28px;height:28px;" fill="none" stroke="#a855f7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 style="font-size:1.2rem;font-weight:700;color:#1e1b4b;margin:0 0 0.75rem;position:relative;z-index:1;">Advanced NLP Scoring</h3>
                    <p style="color:#64748b;line-height:1.7;margin:0;position:relative;z-index:1;">TF-IDF and Cosine Similarity algorithms calculate a precise Match Score so you focus only on the best candidates.</p>
                </div>

                <!-- Card 3 -->
                <div style="background:#faf5ff;border:1px solid #ede9fe;border-radius:20px;padding:2rem;transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width:56px;height:56px;background:#ede9fe;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <svg style="width:28px;height:28px;" fill="none" stroke="#7C3AED" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 style="font-size:1.2rem;font-weight:700;color:#1e1b4b;margin:0 0 0.75rem;">Role-Based Portals</h3>
                    <p style="color:#64748b;line-height:1.7;margin:0;">Dedicated dashboards for HR teams to post jobs and review applicants, and candidates to apply and track scores.</p>
                </div>
            </div>
        </div>
    </section>



    <!-- CTA Section -->
    <section style="width:100%;padding:80px 0;background:linear-gradient(135deg,#1e1b4b 0%,#2e1065 50%,#1e1b4b 100%);position:relative;overflow:hidden;">
        <div style="position:absolute;top:-100px;right:-100px;width:500px;height:500px;background:rgba(124,58,237,0.2);border-radius:50%;filter:blur(80px);"></div>
        <div style="position:absolute;bottom:-100px;left:-100px;width:400px;height:400px;background:rgba(192,132,252,0.15);border-radius:50%;filter:blur(80px);"></div>
        <div style="text-align:center;position:relative;z-index:1;">
            <h2 style="font-size:2.5rem;font-weight:800;color:white;margin:0 0 1rem;">Ready to transform your hiring?</h2>
            <p style="font-size:1.1rem;color:#c4b5fd;max-width:500px;margin:0 auto 2.5rem;">Join companies using AI to find the perfect candidates faster and with less bias.</p>
            <a href="{{ route('register') }}" style="display:inline-block;padding:1rem 2.5rem;background:white;color:#7C3AED;font-weight:800;font-size:1.05rem;border-radius:14px;text-decoration:none;box-shadow:0 8px 24px rgba(255,255,255,0.2);transition:transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                Create Free Account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background:#0f0a1e;border-top:1px solid #1e1b4b;padding:2rem 0;text-align:center;color:#64748b;font-size:0.875rem;">
        &copy; {{ date('Y') }} ResumeAnalyzer AI. All rights reserved.
    </footer>

</body>
</html>
