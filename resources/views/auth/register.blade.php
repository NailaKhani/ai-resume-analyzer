<x-guest-layout>
    <div style="text-align:center;margin-bottom:2rem;">
        <h2 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0 0 0.4rem;letter-spacing:-0.02em;">Create Account</h2>
        <p style="font-size:0.9rem;color:#64748b;margin:0;">Join ResumeAnalyzer and start hiring smarter.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom:1.1rem;">
            <label for="name" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;transition:border 0.2s,box-shadow 0.2s;box-sizing:border-box;background:#faf5ff;"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.1rem;">
            <label for="email" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;transition:border 0.2s,box-shadow 0.2s;box-sizing:border-box;background:#faf5ff;"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.1rem;">
            <label for="role" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">I am a...</label>
            <select id="role" name="role" required
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;background:#faf5ff;color:#1e1b4b;box-sizing:border-box;cursor:pointer;"
                onfocus="this.style.borderColor='#7C3AED'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="" disabled selected>Select your role...</option>
                <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR Manager — Post Jobs &amp; Review Candidates</option>
                <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>Candidate — Find Jobs &amp; Apply</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.1rem;">
            <label for="password" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;transition:border 0.2s,box-shadow 0.2s;box-sizing:border-box;background:#faf5ff;"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.75rem;">
            <label for="password_confirmation" style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                style="width:100%;padding:0.75rem 1rem;border-radius:10px;border:1.5px solid #e2e8f0;font-size:0.9rem;font-family:'Outfit',sans-serif;outline:none;transition:border 0.2s,box-shadow 0.2s;box-sizing:border-box;background:#faf5ff;"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"/>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
            style="width:100%;padding:0.875rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:800;font-size:1rem;border:none;cursor:pointer;box-shadow:0 6px 20px rgba(124,58,237,0.3);font-family:'Outfit',sans-serif;transition:opacity 0.2s,transform 0.2s;"
            onmouseover="this.style.opacity='0.92';this.style.transform='translateY(-1px)'"
            onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
            Create Account
        </button>

        <div style="margin-top:1.5rem;text-align:center;padding-top:1.5rem;border-top:1px solid #f0eaff;">
            <span style="font-size:0.875rem;color:#64748b;">Already have an account? </span>
            <a href="{{ route('login') }}" style="font-size:0.875rem;color:#7C3AED;font-weight:700;text-decoration:none;">Sign In &rarr;</a>
        </div>
    </form>
</x-guest-layout>
