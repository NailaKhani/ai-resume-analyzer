<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div style="text-align:center;margin-bottom:2rem;">
        <h2 style="font-size:1.8rem;font-weight:900;color:#0F172A;margin:0 0 0.4rem;letter-spacing:-0.03em;">Welcome Back</h2>
        <p style="font-size:0.92rem;color:#64748B;margin:0;font-weight:500;">Sign in to access your ResumeIQ workspace.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:1.35rem;">
            <label for="email" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com" class="iq-input" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.35rem;">
            <label for="password" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="iq-input" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.85rem;">
            <label style="display:flex;align-items:center;gap:0.55rem;cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="width:17px;height:17px;border-radius:5px;accent-color:#4F46E5;cursor:pointer;">
                <span style="font-size:0.86rem;color:#64748B;font-weight:600;">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:0.86rem;color:#4F46E5;font-weight:700;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#3730A3'" onmouseout="this.style.color='#4F46E5'">Forgot password?</a>
            @endif
        </div>

        <button type="submit" style="width:100%;padding:0.88rem;border-radius:50px;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:white;font-weight:800;font-size:0.98rem;border:none;cursor:pointer;box-shadow:0 8px 22px -4px rgba(79,70,229,0.4);font-family:'Outfit',sans-serif;transition:transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px -4px rgba(79,70,229,0.5)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 22px -4px rgba(79,70,229,0.4)'">
            Sign In to Account
        </button>

        <div style="margin-top:1.6rem;text-align:center;padding-top:1.4rem;border-top:1px solid #F1F5F9;">
            <span style="font-size:0.88rem;color:#64748B;font-weight:500;">Don't have an account? </span>
            <a href="{{ route('register') }}" style="font-size:0.88rem;color:#4F46E5;font-weight:800;text-decoration:none;margin-left:2px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Get Started &rarr;</a>
        </div>
    </form>
</x-guest-layout>

