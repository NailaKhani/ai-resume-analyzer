<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
            
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">Profile Avatar</label>
                <div style="display:flex;align-items:center;gap:1rem;">
                    @if($user->avatar)
                        <div style="width:64px;height:64px;border-radius:50%;overflow:hidden;border:2px solid #ddd6fe;">
                            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    @else
                        <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:1.5rem;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <input type="file" name="avatar" class="form-input" style="padding:0.5rem;" accept="image/*">
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input class="form-input" id="name" name="name" type="text"
                    value="{{ old('name', $user->name) }}" required autocomplete="name"
                    onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-input" id="email" name="email" type="email"
                    value="{{ old('email', $user->email) }}" required autocomplete="username" readonly
                    style="background-color: #f8fafc; color: #64748b; cursor: not-allowed; border-color: #e2e8f0;">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div style="margin-top:0.75rem;padding:0.75rem 1rem;background:#fef3c7;border-radius:10px;border:1px solid #fde68a;">
                        <p style="font-size:0.82rem;color:#92400e;margin:0;">
                            Your email address is unverified.
                            <button form="send-verification" style="color:#7C3AED;font-weight:700;background:none;border:none;cursor:pointer;text-decoration:underline;font-family:'Outfit',sans-serif;font-size:0.82rem;">
                                Click here to re-send verification email.
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p style="font-size:0.82rem;color:#059669;margin:0.5rem 0 0;font-weight:600;">Verification link sent!</p>
                        @endif
                    </div>
                @endif
            </div>

            @if(auth()->user()->role === 'candidate')
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input class="form-input" id="phone" name="phone" type="text"
                    value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900"
                    onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div class="form-group">
                <label class="form-label" for="linkedin_url">LinkedIn URL</label>
                <input class="form-input" id="linkedin_url" name="linkedin_url" type="url"
                    value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="https://linkedin.com/in/username"
                    onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="skills">Skills (comma separated)</label>
                <input class="form-input" id="skills" name="skills" type="text"
                    value="{{ old('skills', $user->skills) }}" placeholder="e.g. PHP, Laravel, Python, Machine Learning"
                    onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                <x-input-error class="mt-2" :messages="$errors->get('skills')" />
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="bio">Bio / Summary</label>
                <textarea class="form-input" id="bio" name="bio" rows="4" placeholder="Tell us about your experience..."
                    onfocus="this.style.borderColor='#7C3AED';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">{{ old('bio', $user->bio) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">Default Resume (PDF/DOCX)</label>
                <div style="border:1.5px dashed #c4b5fd;background:#faf5ff;border-radius:12px;padding:1.5rem;text-align:center;">
                    @if($user->default_resume)
                        <div style="margin-bottom:1rem;color:#059669;font-weight:700;font-size:0.9rem;">
                            <svg style="width:20px;height:20px;display:inline-block;vertical-align:middle;margin-right:0.3rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Resume uploaded. You can upload a new one to replace it.
                        </div>
                    @endif
                    <input type="file" name="default_resume" class="form-input" style="padding:0.5rem;" accept=".pdf,.docx">
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('default_resume')" />
            </div>
            @endif

        </div>

        <div style="display:flex;align-items:center;gap:1rem;margin-top:1.5rem;border-top:1px solid #f5f3ff;padding-top:1.5rem;">
            <button type="submit" class="save-btn">Save Changes</button>
            @if (session('success') === 'Profile updated successfully.')
                <span style="font-size:0.85rem;color:#059669;font-weight:700;display:flex;align-items:center;gap:0.3rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Saved successfully!
                </span>
            @endif
        </div>
    </form>
</section>
