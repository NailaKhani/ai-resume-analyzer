<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Analyzer AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Outfit', sans-serif; 
            background: #0f172a; 
            color: #f8fafc;
            overflow-x: hidden;
        }

        /* Nav */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .logo { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px; }
        .logo span { background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            margin-left: 2rem;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: #fff; }
        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-glass:hover { background: rgba(255, 255, 255, 0.2); transform: translateY(-2px); }

        /* Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(56,189,248,0.2) 0%, rgba(15,23,42,0) 70%);
            top: -200px;
            left: -200px;
            border-radius: 50%;
            z-index: -1;
        }
        .hero-content { flex: 1; z-index: 1; padding-right: 3rem; }
        .hero h1 {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .hero h1 span {
            background: linear-gradient(135deg, #38bdf8, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero p {
            font-size: 1.25rem;
            color: #94a3b8;
            margin-bottom: 2.5rem;
            max-width: 600px;
            line-height: 1.6;
        }
        .btn-primary {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            color: #fff;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(56,189,248,0.3);
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(56,189,248,0.4); }
        
        .hero-image {
            flex: 1;
            position: relative;
            z-index: 1;
        }
        .hero-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s;
        }
        .hero-image img:hover { transform: perspective(1000px) rotateY(0deg) rotateX(0deg); }

        /* Features */
        .features { padding: 6rem 5%; background: #0b1120; }
        .section-title { text-align: center; font-size: 2.5rem; margin-bottom: 4rem; font-weight: 700; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 20px;
            transition: transform 0.3s, background 0.3s;
        }
        .glass-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(56,189,248,0.3);
        }
        .glass-card h3 { font-size: 1.5rem; margin-bottom: 1rem; color: #fff; }
        .glass-card p { color: #94a3b8; line-height: 1.6; }
        .icon-box {
            width: 60px; height: 60px;
            border-radius: 15px;
            background: linear-gradient(135deg, rgba(56,189,248,0.2), rgba(129,140,248,0.2));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 800; color: #38bdf8;
            margin-bottom: 1.5rem;
        }

    </style>
</head>
<body>

    <nav>
        <div class="logo">Resume<span>Analyzer</span></div>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-glass">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-glass" style="margin-left: 1.5rem;">Get Started</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Hire smarter with <span>AI-Powered</span> Insights.</h1>
            <p>Our intelligent system analyzes resumes against job descriptions in seconds, giving you an accurate Match Score using advanced Natural Language Processing. Say goodbye to manual screening.</p>
            <a href="{{ route('register') }}" class="btn-primary">Start Analyzing Free</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/hero.jpg') }}" alt="AI Resume Analysis">
        </div>
    </section>

    <section class="features">
        <h2 class="section-title">Why Choose Resume Analyzer?</h2>
        <div class="grid">
            <div class="glass-card">
                <div class="icon-box">01</div>
                <h3>Smart Skill Extraction</h3>
                <p>Our AI reads through PDF and DOCX files to automatically extract core skills and competencies, mapping them directly to your job requirements.</p>
            </div>
            <div class="glass-card">
                <div class="icon-box">02</div>
                <h3>Advanced NLP Scoring</h3>
                <p>Using TF-IDF and Cosine Similarity algorithms, we calculate a precise Match Score so you can focus on the most qualified candidates instantly.</p>
            </div>
            <div class="glass-card">
                <div class="icon-box">03</div>
                <h3>Role-Based Portals</h3>
                <p>Dedicated modern dashboards for HR teams to post jobs and review applicants, and for candidates to easily apply and track their scores.</p>
            </div>
        </div>
    </section>

</body>
</html>
