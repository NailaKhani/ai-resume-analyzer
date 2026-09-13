<section>
    <p style="font-size:0.875rem;color:#64748b;line-height:1.6;margin:0 0 1.5rem;">
        Once your account is deleted, all of your data will be permanently removed. Please download any important data before proceeding.
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.5rem;border-radius:10px;background:#fff1f2;color:#dc2626;border:1.5px solid #fecdd3;font-weight:700;font-size:0.875rem;cursor:pointer;font-family:'Outfit',sans-serif;transition:background 0.2s;"
        onmouseover="this.style.background='#fecdd3'"
        onmouseout="this.style.background='#fff1f2'">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Delete My Account
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding:2rem;">
            @csrf
            @method('delete')

            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem;">
                <div style="width:44px;height:44px;border-radius:12px;background:#fff1f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h2 style="font-size:1.1rem;font-weight:800;color:#dc2626;margin:0;">Delete Account?</h2>
            </div>

            <p style="font-size:0.875rem;color:#64748b;margin:0 0 1.5rem;line-height:1.6;">
                This action is <strong style="color:#dc2626;">permanent and irreversible</strong>. All your data will be deleted. Enter your password to confirm.
            </p>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block;font-size:0.85rem;font-weight:700;color:#374151;margin-bottom:0.5rem;">Your Password</label>
                <input id="password" name="password" type="password"
                    placeholder="Enter your password..."
                    style="width:100%;padding:0.8rem 1rem;border-radius:10px;border:1.5px solid #fecdd3;background:#fff1f2;font-size:0.9rem;outline:none;box-sizing:border-box;font-family:'Outfit',sans-serif;color:#1e1b4b;"
                    onfocus="this.style.borderColor='#dc2626';this.style.boxShadow='0 0 0 3px rgba(220,38,38,0.1)'"
                    onblur="this.style.borderColor='#fecdd3';this.style.boxShadow='none'">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div style="display:flex;justify-content:flex-end;gap:0.75rem;">
                <button type="button" x-on:click="$dispatch('close')"
                    style="padding:0.7rem 1.25rem;border-radius:10px;border:1.5px solid #e2e8f0;background:white;color:#64748b;font-weight:600;font-size:0.875rem;cursor:pointer;font-family:'Outfit',sans-serif;">
                    Cancel
                </button>
                <button type="submit"
                    style="padding:0.7rem 1.5rem;border-radius:10px;background:#dc2626;color:white;font-weight:800;font-size:0.875rem;border:none;cursor:pointer;font-family:'Outfit',sans-serif;box-shadow:0 4px 12px rgba(220,38,38,0.25);">
                    Yes, Delete Account
                </button>
            </div>
        </form>
    </x-modal>
</section>
