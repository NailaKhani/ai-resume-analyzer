<section>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label class="form-label" for="update_password_current_password">Current Password</label>
            <input class="form-input" id="update_password_current_password" name="current_password" type="password"
                autocomplete="current-password"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="form-group">
            <label class="form-label" for="update_password_password">New Password</label>
            <input class="form-input" id="update_password_password" name="password" type="password"
                autocomplete="new-password"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="form-group">
            <label class="form-label" for="update_password_password_confirmation">Confirm New Password</label>
            <input class="form-input" id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password"
                onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div style="display:flex;align-items:center;gap:1rem;margin-top:0.5rem;">
            <button type="submit" class="save-btn"
                style="background:linear-gradient(135deg,#a855f7,#ec4899);">
                Update Password
            </button>
            @if (session('status') === 'password-updated')
                <span style="font-size:0.85rem;color:#059669;font-weight:700;display:flex;align-items:center;gap:0.3rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Updated!
                </span>
            @endif
        </div>
    </form>
</section>
