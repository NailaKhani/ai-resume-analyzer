@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

<style>
    .profile-card { background:white; border-radius:20px; border:1px solid #f0eaff; box-shadow:0 4px 20px rgba(124,58,237,0.07); overflow:hidden; margin-bottom:1.5rem; }
    .profile-card-header { padding:1.75rem 2rem; border-bottom:1px solid #f5f3ff; }
    .profile-card-body { padding:2rem; }
    .form-label { display:block; font-size:0.85rem; font-weight:700; color:#374151; margin-bottom:0.5rem; }
    .form-input { width:100%; padding:0.8rem 1rem; border-radius:10px; border:1.5px solid #e2e8f0; background:#faf5ff; font-size:0.9rem; outline:none; transition:border 0.2s,box-shadow 0.2s; box-sizing:border-box; font-family:'Outfit',sans-serif; color:#1e1b4b; }
    .form-input:focus { border-color:#7C3AED; box-shadow:0 0 0 3px rgba(124,58,237,0.1); background:white; }
    .form-group { margin-bottom:1.4rem; }
    .save-btn { padding:0.75rem 2rem; border-radius:12px; background:linear-gradient(135deg,#7C3AED,#C084FC); color:white; font-weight:800; font-size:0.9rem; border:none; cursor:pointer; box-shadow:0 4px 14px rgba(124,58,237,0.25); font-family:'Outfit',sans-serif; transition:opacity 0.2s,transform 0.2s; }
    .save-btn:hover { opacity:0.9; transform:translateY(-1px); }
    .section-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
</style>

{{-- Page Header --}}
<div style="margin-bottom:2rem;">
    <div style="display:flex;align-items:center;gap:1rem;">
        <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(124,58,237,0.3);">
            <svg width="26" height="26" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0;letter-spacing:-0.02em;">My Profile</h1>
            <p style="color:#64748b;font-size:0.875rem;margin:0.2rem 0 0;">Manage your account settings and security preferences.</p>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;">

    {{-- Left Column --}}
    <div>
        {{-- Profile Info Card --}}
        <div class="profile-card">
            <div class="profile-card-header" style="display:flex;align-items:center;gap:1rem;">
                <div class="section-icon" style="background:#ede9fe;">
                    <svg width="22" height="22" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Profile Information</h2>
                    <p style="font-size:0.82rem;color:#94a3b8;margin:0.2rem 0 0;">Update your name and email address.</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="profile-card" style="border-color:#fecdd3;">
            <div class="profile-card-header" style="display:flex;align-items:center;gap:1rem;background:#fff1f2;">
                <div class="section-icon" style="background:#fecdd3;">
                    <svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h2 style="font-size:1.05rem;font-weight:800;color:#dc2626;margin:0;">Delete Account</h2>
                    <p style="font-size:0.82rem;color:#f87171;margin:0.2rem 0 0;">Permanently remove your account and all data.</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div>
        {{-- Change Password Card --}}
        <div class="profile-card">
            <div class="profile-card-header" style="display:flex;align-items:center;gap:1rem;">
                <div class="section-icon" style="background:#fae8ff;">
                    <svg width="22" height="22" fill="none" stroke="#a855f7" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Update Password</h2>
                    <p style="font-size:0.82rem;color:#94a3b8;margin:0.2rem 0 0;">Use a long, random password to stay secure.</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Account Info Summary --}}
        <div class="profile-card">
            <div class="profile-card-header" style="display:flex;align-items:center;gap:1rem;">
                <div class="section-icon" style="background:#d1fae5;">
                    <svg width="22" height="22" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Account Details</h2>
                    <p style="font-size:0.82rem;color:#94a3b8;margin:0.2rem 0 0;">Your current account information.</p>
                </div>
            </div>
            <div class="profile-card-body">
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div style="display:flex;align-items:center;gap:1rem;padding:1rem;background:#faf5ff;border-radius:12px;border:1px solid #ede9fe;">
                        <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:1.2rem;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p style="font-weight:800;color:#1e1b4b;margin:0;font-size:0.95rem;">{{ auth()->user()->name }}</p>
                            <p style="color:#94a3b8;margin:0.2rem 0 0;font-size:0.8rem;">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0.875rem 1rem;background:#faf5ff;border-radius:10px;border:1px solid #ede9fe;">
                        <span style="font-size:0.85rem;color:#64748b;font-weight:600;">Role</span>
                        <span style="font-size:0.85rem;font-weight:800;color:#7C3AED;">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0.875rem 1rem;background:#faf5ff;border-radius:10px;border:1px solid #ede9fe;">
                        <span style="font-size:0.85rem;color:#64748b;font-weight:600;">Member Since</span>
                        <span style="font-size:0.85rem;font-weight:700;color:#1e1b4b;">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:0.875rem 1rem;background:#d1fae5;border-radius:10px;border:1px solid #a7f3d0;">
                        <span style="font-size:0.85rem;color:#065f46;font-weight:600;">Account Status</span>
                        <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:700;color:#059669;">
                            <span style="width:7px;height:7px;border-radius:50%;background:#10b981;display:inline-block;"></span>
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
