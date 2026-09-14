<x-guest-layout>
    <div style="text-align:center;margin-bottom:2rem;">
        <h2 style="font-size:1.8rem;font-weight:900;color:#0F172A;margin:0 0 0.4rem;letter-spacing:-0.03em;">Create Your Account</h2>
        <p style="font-size:0.92rem;color:#64748B;margin:0;font-weight:500;">Join ResumeIQ to start hiring or applying with AI match scores.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom:1.2rem;">
            <label for="name" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" class="iq-input" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.2rem;">
            <label for="email" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@company.com" class="iq-input" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.2rem;">
            <label for="role" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Account Type</label>
            <select id="role" name="role" required class="iq-select" style="cursor:pointer;">
                <option value="" disabled selected>Select account type...</option>
                <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR Manager — Post Jobs &amp; Review Applicants</option>
                <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>Candidate — Browse Jobs &amp; Apply</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.2rem;">
            <label for="password" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="iq-input" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div style="margin-bottom:1.85rem;">
            <label for="password_confirmation" style="display:block;font-size:0.85rem;font-weight:800;color:#334155;margin-bottom:0.45rem;letter-spacing:-0.01em;">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="iq-input" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" style="width:100%;padding:0.88rem;border-radius:50px;background:linear-gradient(135deg,#4F46E5,#7C3AED);color:white;font-weight:800;font-size:0.98rem;border:none;cursor:pointer;box-shadow:0 8px 22px -4px rgba(79,70,229,0.4);font-family:'Outfit',sans-serif;transition:transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px -4px rgba(79,70,229,0.5)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 22px -4px rgba(79,70,229,0.4)'">
            Create Free Account
        </button>

        <div style="margin-top:1.6rem;text-align:center;padding-top:1.4rem;border-top:1px solid #F1F5F9;">
            <span style="font-size:0.88rem;color:#64748B;font-weight:500;">Already registered? </span>
            <a href="{{ route('login') }}" style="font-size:0.88rem;color:#4F46E5;font-weight:800;text-decoration:none;margin-left:2px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Sign In &rarr;</a>
        </div>
    </form>
</x-guest-layout>

