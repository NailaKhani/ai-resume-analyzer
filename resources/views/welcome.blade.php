<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Analyzer AI — Turn Resumes Into Placement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { 
            margin: 0; 
            padding: 0; 
            background: #F8FAFC; 
            font-family: 'Outfit', sans-serif; 
            color: #0F172A;
            overflow-x: hidden; 
        }

        .container-xl {
            max-width: 1280px;
            margin: 0 auto;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* Glass Floating Animations */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(2deg); }
        }

        @keyframes floatMedium {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(-2deg); }
        }

        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(12px) rotate(1.5deg); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.06); }
        }

        @keyframes badgePing {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .animate-float-slow { animation: floatSlow 5s ease-in-out infinite; }
        .animate-float-medium { animation: floatMedium 4s ease-in-out infinite 0.5s; }
        .animate-float-reverse { animation: floatReverse 5.5s ease-in-out infinite 1s; }
        .animate-pulse-glow { animation: pulseGlow 4s ease-in-out infinite; }

        /* Floating Tech Badge Pill Styling */
        .tech-pill {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
            border-radius: 16px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #1E293B;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .tech-pill:hover {
            transform: scale(1.1) translateY(-4px) !important;
            box-shadow: 0 20px 30px -10px rgba(79, 70, 229, 0.25);
            border-color: #6366F1;
        }

        /* Card Hover Effects */
        .feature-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 20px;
            padding: 1.8rem;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(79, 70, 229, 0.12);
            border-color: #C7D2FE;
        }

        .gradient-text {
            background: linear-gradient(135deg, #2563EB 0%, #4F46E5 50%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header style="position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: rgba(255, 255, 255, 0.88); backdrop-filter: blur(16px); border-bottom: 1px solid #E2E8F0;">
        <div class="container-xl" style="display: flex; justify-content: space-between; align-items: center; height: 74px;">
            
            <!-- Brand Logo -->
            <a href="/" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #3B82F6, #4F46E5); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span style="font-size: 1.4rem; font-weight: 900; color: #0F172A; letter-spacing: -0.03em;">Resume<span style="color: #4F46E5;">IQ</span></span>
            </a>

            <!-- Desktop Menu Nav Links -->
            <nav style="display: flex; align-items: center; gap: 2rem;">
                <a href="#features" style="color: #475569; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Features</a>
                <a href="#roles" style="color: #475569; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Multi-Role</a>
                <a href="#analytics" style="color: #475569; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">Analytics</a>
                <a href="#ai-engine" style="color: #475569; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4F46E5'" onmouseout="this.style.color='#475569'">AI Engine</a>
            </nav>

            <!-- Auth Buttons -->
            <div style="display: flex; align-items: center; gap: 1rem;">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" style="display: inline-flex; align-items: center; padding: 0.65rem 1.6rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 700; text-decoration: none; font-size: 0.92rem; box-shadow: 0 4px 16px rgba(79, 70, 229, 0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="color: #334155; font-weight: 700; font-size: 0.95rem; text-decoration: none; padding: 0.6rem 1rem;">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; padding: 0.65rem 1.6rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 700; text-decoration: none; font-size: 0.92rem; box-shadow: 0 4px 16px rgba(79, 70, 229, 0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Main Hero Section (Desktop SapphireIQ Inspired Layout) -->
    <section style="position: relative; padding-top: 130px; padding-bottom: 70px; overflow: hidden; background: radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.08) 0%, transparent 50%), radial-gradient(circle at 80% 60%, rgba(168, 85, 247, 0.08) 0%, transparent 50%);">
        <div class="container-xl">
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 3rem; min-height: 520px;">
                
                <!-- Left Hero Text Column -->
                <div style="flex: 0 0 48%; max-width: 48%;">
                    
                    <!-- Eyebrow Pill -->
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.45rem 1.1rem; border-radius: 50px; background: #EEF2FF; border: 1px solid #C7D2FE; margin-bottom: 1.5rem;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #4F46E5; animation: badgePing 1.8s infinite; display: inline-block;"></span>
                        <span style="font-size: 0.82rem; font-weight: 800; color: #4F46E5; letter-spacing: 0.05em; text-transform: uppercase;">AI Recruitment Accelerator</span>
                    </div>

                    <!-- Main Desktop Headline -->
                    <h1 style="font-size: clamp(2.8rem, 4.2vw, 4.2rem); font-weight: 900; color: #0F172A; line-height: 1.08; margin: 0 0 1.25rem 0; letter-spacing: -0.03em;">
                        Turn Resumes <br>Into <span class="gradient-text">Placement.</span>
                    </h1>

                    <!-- Description Subtitle -->
                    <p style="font-size: 1.12rem; color: #475569; line-height: 1.7; margin: 0 0 2.2rem 0; max-width: 520px;">
                        Collaborate with automated AI screening, match candidates using hybrid Sentence-BERT NLP, and streamline your entire recruitment pipeline with live analytics.
                    </p>

                    <!-- Dual Desktop CTA Buttons -->
                    <div style="display: flex; gap: 1.2rem; align-items: center;">
                        <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.95rem 2.2rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 800; font-size: 1rem; text-decoration: none; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            Apply Now
                        </a>
                        <a href="#features" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.95rem 2rem; border-radius: 50px; background: white; border: 1.5px solid #E2E8F0; color: #1E293B; font-weight: 700; font-size: 1rem; text-decoration: none; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04); transition: all 0.3s ease;" onmouseover="this.style.borderColor='#4F46E5'; this.style.color='#4F46E5';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.color='#1E293B';">
                            Explore Features <span style="font-size: 1.1rem;">→</span>
                        </a>
                    </div>

                </div>

                <!-- Right Visual Column (Floating Animated Tech Orbit Showcase) -->
                <div style="flex: 0 0 48%; max-width: 48%; position: relative;">
                    
                    <!-- Glow Backdrop -->
                    <div class="animate-pulse-glow" style="position: absolute; top: 10%; left: 10%; right: 10%; bottom: 10%; background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(168, 85, 247, 0.25) 50%, transparent 80%); filter: blur(40px); border-radius: 50%; pointer-events: none;"></div>

                    <!-- Orbiting Tech Stack Badges (Matching Screenshot Floating Icons!) -->
                    <div class="tech-pill animate-float-slow" style="top: -15px; left: 10%;">
                        <span style="font-size: 1.2rem;">🐍</span>
                        <span>Python AI</span>
                    </div>

                    <div class="tech-pill animate-float-medium" style="top: -20px; right: 8%;">
                        <span style="font-size: 1.2rem;">⚛️</span>
                        <span>FastAPI Engine</span>
                    </div>

                    <div class="tech-pill animate-float-reverse" style="top: 40%; left: -35px;">
                        <span style="font-size: 1.2rem;">🗄️</span>
                        <span>MySQL DB</span>
                    </div>

                    <div class="tech-pill animate-float-slow" style="top: 35%; right: -30px;">
                        <span style="font-size: 1.2rem;">🧠</span>
                        <span>SBERT NLP</span>
                    </div>

                    <div class="tech-pill animate-float-medium" style="bottom: 10px; left: 5%;">
                        <span style="font-size: 1.2rem;">📊</span>
                        <span>Chart.js Analytics</span>
                    </div>

                    <div class="tech-pill animate-float-reverse" style="bottom: 5px; right: 10%;">
                        <span style="font-size: 1.2rem;">📄</span>
                        <span>PDF/DOCX Parser</span>
                    </div>

                    <!-- Central Dark Dashboard Mockup Card (Exact Replica of Modern UI Mockup) -->
                    <div style="position: relative; background: #0F172A; border: 1.5px solid rgba(255, 255, 255, 0.12); border-radius: 28px; padding: 22px; box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.4); transform: perspective(1000px) rotateY(-4deg) rotateX(2deg); transition: transform 0.5s ease;" onmouseover="this.style.transform='perspective(1000px) rotateY(0deg) rotateX(0deg)'" onmouseout="this.style.transform='perspective(1000px) rotateY(-4deg) rotateX(2deg)'">
                        
                        <!-- Top Mockup Window Controls -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 16px;">
                            <div style="display: flex; gap: 8px;">
                                <span style="width: 11px; height: 11px; border-radius: 50%; background: #EF4444; display: inline-block;"></span>
                                <span style="width: 11px; height: 11px; border-radius: 50%; background: #F59E0B; display: inline-block;"></span>
                                <span style="width: 11px; height: 11px; border-radius: 50%; background: #10B981; display: inline-block;"></span>
                            </div>
                            <span style="font-size: 0.78rem; font-weight: 700; color: #94A3B8; letter-spacing: 0.04em;">RESUME_ANALYZER_LIVE_AI</span>
                            <span style="padding: 2px 8px; border-radius: 20px; background: rgba(16, 185, 129, 0.15); color: #34D399; font-size: 0.72rem; font-weight: 700;">Active 98.4%</span>
                        </div>

                        <!-- Inner Dashboard Content Grid -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                            
                            <!-- Widget 1: Total Candidates -->
                            <div style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 16px; padding: 14px;">
                                <span style="font-size: 0.75rem; color: #94A3B8; font-weight: 600;">Total Screened Resumes</span>
                                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-top: 6px;">
                                    <span style="font-size: 1.6rem; font-weight: 900; color: white;">148</span>
                                    <span style="font-size: 0.75rem; color: #34D399; font-weight: 700;">+24.5% ↑</span>
                                </div>
                            </div>

                            <!-- Widget 2: AI Match Accuracy -->
                            <div style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 16px; padding: 14px;">
                                <span style="font-size: 0.75rem; color: #94A3B8; font-weight: 600;">Top AI Match Score</span>
                                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-top: 6px;">
                                    <span style="font-size: 1.6rem; font-weight: 900; color: #818CF8;">96.8%</span>
                                    <span style="font-size: 0.75rem; color: #818CF8; font-weight: 700;">SBERT NLP</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar Metrics -->
                        <div style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 16px; padding: 14px; margin-bottom: 14px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 0.78rem;">
                                <span style="color: #E2E8F0; font-weight: 600;">Python & Data Science</span>
                                <span style="color: #818CF8; font-weight: 700;">94% Match</span>
                            </div>
                            <div style="width: 100%; height: 7px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; overflow: hidden;">
                                <div style="width: 94%; height: 100%; background: linear-gradient(90deg, #3B82F6, #818CF8); border-radius: 10px;"></div>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin-top: 10px; margin-bottom: 6px; font-size: 0.78rem;">
                                <span style="color: #E2E8F0; font-weight: 600;">Full Stack Web Developer</span>
                                <span style="color: #34D399; font-weight: 700;">88% Match</span>
                            </div>
                            <div style="width: 100%; height: 7px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; overflow: hidden;">
                                <div style="width: 88%; height: 100%; background: linear-gradient(90deg, #10B981, #34D399); border-radius: 10px;"></div>
                            </div>
                        </div>

                        <!-- Bottom Live Log Status -->
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem; color: #64748B; background: rgba(15, 23, 42, 0.8); padding: 8px 12px; border-radius: 10px;">
                            <span>⚡ Fast Analysis (< 1.2s response time)</span>
                            <span style="color: #A7F3D0;">● Verified Pipeline</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Bottom Feature Cards Row (Exact 4 Cards layout from Screenshot) -->
    <section id="features" style="padding: 40px 0 80px 0; background: #F8FAFC;">
        <div class="container-xl">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                
                <!-- Card 1 -->
                <div class="feature-card">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #EEF2FF; color: #4F46E5; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 900; margin-bottom: 1rem;">
                        ⚡
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0F172A; margin: 0 0 0.5rem 0;">Real-World AI Parsing</h3>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.6; margin: 0;">
                        Extract skills, education, and experience directly from PDF & DOCX resumes with high precision.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="feature-card">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #F0FDF4; color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 900; margin-bottom: 1rem;">
                        🧠
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0F172A; margin: 0 0 0.5rem 0;">Hybrid SBERT Engine</h3>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.6; margin: 0;">
                        Combines Sentence-BERT embeddings with TF-IDF cosine similarity for intelligent semantic scoring.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="feature-card">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #F3E8FF; color: #9333EA; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 900; margin-bottom: 1rem;">
                        👑
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0F172A; margin: 0 0 0.5rem 0;">Multi-Role Security</h3>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.6; margin: 0;">
                        Tailored portals for Admin monitoring, HR candidate management, and Candidate job applications.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="feature-card">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 900; margin-bottom: 1rem;">
                        📊
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0F172A; margin: 0 0 0.5rem 0;">Chart.js Analytics</h3>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.6; margin: 0;">
                        Visual dashboards with interactive charts tracking candidate conversion and job application trends.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Detailed Section: Multi-Role System -->
    <section id="roles" style="padding: 80px 0; background: #FFFFFF; border-top: 1px solid #E2E8F0;">
        <div class="container-xl">
            <div style="text-align: center; max-width: 650px; margin: 0 auto 3.5rem auto;">
                <span style="font-size: 0.85rem; font-weight: 800; color: #4F46E5; text-transform: uppercase; letter-spacing: 0.05em;">Designed for Teams</span>
                <h2 style="font-size: 2.2rem; font-weight: 900; color: #0F172A; margin: 0.5rem 0 1rem 0;">Tailored Interfaces for Every Role</h2>
                <p style="font-size: 1.05rem; color: #64748B; margin: 0;">Experience clean, distraction-free dashboards built specifically for your responsibilities.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                
                <!-- Admin Role -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 24px; padding: 2rem; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="display: inline-flex; padding: 10px; border-radius: 12px; background: #EEF2FF; color: #4F46E5; font-size: 1.5rem; margin-bottom: 1.25rem;">👑</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0F172A; margin: 0 0 0.75rem 0;">Super Admin</h3>
                    <ul style="padding-left: 1.2rem; color: #475569; font-size: 0.95rem; line-height: 1.8; margin: 0;">
                        <li>Full system metrics & user management</li>
                        <li>Assign & revoke HR permissions</li>
                        <li>Real-time activity audit logs</li>
                    </ul>
                </div>

                <!-- HR Role -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 24px; padding: 2rem; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="display: inline-flex; padding: 10px; border-radius: 12px; background: #F0FDF4; color: #10B981; font-size: 1.5rem; margin-bottom: 1.25rem;">💼</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0F172A; margin: 0 0 0.75rem 0;">HR Manager</h3>
                    <ul style="padding-left: 1.2rem; color: #475569; font-size: 0.95rem; line-height: 1.8; margin: 0;">
                        <li>Post & manage job openings</li>
                        <li>Instant AI resume match ranking</li>
                        <li>Candidate status tracking & charts</li>
                    </ul>
                </div>

                <!-- Candidate Role -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 24px; padding: 2rem; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="display: inline-flex; padding: 10px; border-radius: 12px; background: #EFF6FF; color: #2563EB; font-size: 1.5rem; margin-bottom: 1.25rem;">🎓</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0F172A; margin: 0 0 0.75rem 0;">Candidate</h3>
                    <ul style="padding-left: 1.2rem; color: #475569; font-size: 0.95rem; line-height: 1.8; margin: 0;">
                        <li>Browse active job opportunities</li>
                        <li>One-click resume submission</li>
                        <li>Track application match feedback</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section style="padding: 90px 0; background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 100%); color: white; position: relative; overflow: hidden;">
        <div class="animate-pulse-glow" style="position: absolute; top: -100px; right: -100px; width: 500px; height: 500px; background: rgba(99, 102, 241, 0.25); border-radius: 50%; filter: blur(80px); pointer-events: none;"></div>
        
        <div class="container-xl" style="text-align: center; position: relative; z-index: 10;">
            <h2 style="font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 900; margin: 0 0 1rem 0; letter-spacing: -0.02em;">Ready to Automate Your Hiring Process?</h2>
            <p style="font-size: 1.15rem; color: #C7D2FE; max-width: 600px; margin: 0 auto 2.5rem auto;">
                Join modern HR teams using our AI-Powered Resume Analyzer for fast, accurate placement.
            </p>
            <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 1rem 2.5rem; border-radius: 50px; background: white; color: #4F46E5; font-weight: 900; font-size: 1.05rem; text-decoration: none; box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2); transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                Create Free Account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #090D16; border-top: 1px solid rgba(255, 255, 255, 0.08); padding: 2.5rem 0; text-align: center; color: #64748B; font-size: 0.9rem;">
        <div class="container-xl" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <span>&copy; {{ date('Y') }} ResumeIQ AI — Built for FYP Demonstration</span>
            <div style="display: flex; gap: 1.5rem;">
                <a href="{{ route('login') }}" style="color: #94A3B8; text-decoration: none;">Login</a>
                <a href="{{ route('register') }}" style="color: #94A3B8; text-decoration: none;">Register</a>
                <a href="#features" style="color: #94A3B8; text-decoration: none;">Features</a>
            </div>
        </div>
    </footer>

</body>
</html>
