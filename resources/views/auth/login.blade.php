<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div style="text-align:center;margin-bottom:2rem;">
        <h2 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0 0 0.4rem;letter-spacing:-0.02em;">Welcome Back</h2>
        <p style="font-size:0.9rem;color:#64748b;margin:0;">Sign in to access your dashboard.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:1.25rem;">
            <label for="email" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;transition:border 0.2s,box-shadow 0.2s;box-sizing:border-box;background:#faf5ff;"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.25rem;">
            <label for="password" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;transition:border 0.2s,box-shadow 0.2s;box-sizing:border-box;background:#faf5ff;"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;">
            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember"
                    style="width:16px;height:16px;accent-color:#7C3AED;cursor:pointer;">
                <span style="font-size:0.85rem;color:#64748b;">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:0.85rem;color:#7C3AED;font-weight:600;text-decoration:none;">Forgot password?</a>
            @endif
        </div>

        <button type="submit"
            style="width:100%;padding:0.875rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:800;font-size:1rem;border:none;cursor:pointer;box-shadow:0 6px 20px rgba(124,58,237,0.3);font-family:'Outfit',sans-serif;transition:opacity 0.2s,transform 0.2s;"
            onmouseover="this.style.opacity='0.92';this.style.transform='translateY(-1px)'"
            onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
            Sign In
        </button>

        <div style="margin-top:1.5rem;text-align:center;padding-top:1.5rem;border-top:1px solid #f0eaff;">
            <span style="font-size:0.875rem;color:#64748b;">Don't have an account? </span>
            <a href="{{ route('register') }}" style="font-size:0.875rem;color:#7C3AED;font-weight:700;text-decoration:none;">Get Started &rarr;</a>
        </div>
    </form>
</x-guest-layout>
