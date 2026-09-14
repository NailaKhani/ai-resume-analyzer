@extends('layouts.app')
@section('title', 'My Profile Settings')

@section('content')

<style>
    .profile-card { background: #FFFFFF; border-radius: 20px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05); overflow: hidden; margin-bottom: 1.5rem; }
    .profile-card-header { padding: 1.75rem 2rem; border-bottom: 1px solid #E2E8F0; }
    .profile-card-body { padding: 2rem; }
    .form-group { margin-bottom: 1.4rem; }
    .save-btn { padding: 0.75rem 2.2rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 800; font-size: 0.9rem; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3); transition: transform 0.2s; }
    .save-btn:hover { transform: translateY(-2px); }
</style>

{{-- Page Header --}}
<div style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg, #3B82F6, #4F46E5); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);">
            <svg width="26" height="26" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0;">Profile Settings</h1>
            <p style="color: #64748B; font-size: 0.92rem; margin: 0.2rem 0 0 0;">Manage your account credentials, avatar, and security preferences.</p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.8rem; align-items: start;">

    {{-- Left Column: Profile Information --}}
    <div>
        <div class="profile-card">
            <div class="profile-card-header" style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #EEF2FF; color: #4F46E5; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0;">Personal Information</h2>
                    <p style="font-size: 0.82rem; color: #64748B; margin: 0.2rem 0 0 0;">Update your name, bio, and profile photo.</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    {{-- Right Column: Security & Password --}}
    <div>
        <div class="profile-card">
            <div class="profile-card-header" style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #FEF3C7; color: #D97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0;">Security & Password</h2>
                    <p style="font-size: 0.82rem; color: #64748B; margin: 0.2rem 0 0 0;">Ensure your account is using a long, random password.</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="profile-card" style="border-color: #FECACA;">
            <div class="profile-card-header" style="display: flex; align-items: center; gap: 1rem; background: #FEE2E2;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #FCA5A5; color: #991B1B; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 800; color: #991B1B; margin: 0;">Delete Account</h2>
                    <p style="font-size: 0.82rem; color: #B91C1C; margin: 0.2rem 0 0 0;">Permanently delete your account and all associated data.</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

</div>

@endsection
