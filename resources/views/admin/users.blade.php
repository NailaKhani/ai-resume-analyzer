@extends('layouts.app')
@section('title', 'User Management')

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0 0 0.4rem 0;">User Management</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Manage registered accounts and role permissions across the system.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" style="padding: 0.65rem 1.4rem; background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE; border-radius: 50px; font-weight: 800; font-size: 0.88rem; text-decoration: none;">
        ← Back to Admin Overview
    </a>
</div>

@if(session('success'))
    <div style="background: #D1FAE5; border: 1px solid #A7F3D0; border-radius: 14px; padding: 0.9rem 1.25rem; margin-bottom: 1.5rem; color: #065F46; font-weight: 700; font-size: 0.9rem;">
        ✓ {{ session('success') }}
    </div>
@endif

<div class="glass-card" style="overflow: hidden;">
    <table class="custom-table">
        <thead>
            <tr>
                <th>User Account</th>
                <th>Role</th>
                <th>Applications</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @if($u->avatar)
                            <img src="{{ Storage::url($u->avatar) }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #C7D2FE;">
                        @else
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3B82F6, #4F46E5); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 0.95rem; flex-shrink: 0;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p style="font-weight: 800; color: #0F172A; margin: 0; font-size: 0.92rem;">{{ $u->name }}</p>
                            <p style="color: #64748B; margin: 0; font-size: 0.78rem;">{{ $u->email }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    @php
                        $roleStyle = match($u->role) {
                            'admin' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                            'hr'    => ['bg' => '#DBEAFE', 'text' => '#1D4ED8'],
                            default => ['bg' => '#EEF2FF', 'text' => '#4F46E5']
                        };
                    @endphp
                    <span style="padding: 4px 12px; background: {{ $roleStyle['bg'] }}; color: {{ $roleStyle['text'] }}; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td style="font-weight: 700; color: #334155;">{{ $u->candidates_count }}</td>
                <td style="color: #64748B; font-size: 0.82rem; font-weight: 600;">{{ $u->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.role', $u->id) }}">
                                @csrf @method('PATCH')
                                <select name="role" onchange="this.form.submit()" style="padding: 4px 10px; font-size: 0.78rem; font-weight: 800; border-radius: 50px; background: #F8FAFC; border: 1.5px solid #CBD5E1; cursor: pointer;">
                                    <option value="candidate" {{ $u->role === 'candidate' ? 'selected' : '' }}>Set Candidate</option>
                                    <option value="hr" {{ $u->role === 'hr' ? 'selected' : '' }}>Set HR</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Set Admin</option>
                                </select>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete this user account?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="padding: 5px 12px; background: #FEE2E2; color: #EF4444; border: 1px solid #FECACA; border-radius: 8px; font-size: 0.78rem; font-weight: 800; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                        @else
                            <span style="font-size: 0.78rem; color: #94A3B8; font-weight: 600;">(Current User)</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
