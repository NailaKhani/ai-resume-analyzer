@extends('layouts.app')
@section('title', 'User Management')

@section('content')

<style>
    .users-card { background:white; border-radius:18px; border:1px solid #f0eaff; box-shadow:0 2px 12px rgba(124,58,237,0.06); overflow:hidden; }
    .badge-role-hr        { background:#dbeafe; color:#1d4ed8; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .badge-role-candidate { background:#ede9fe; color:#7C3AED; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .badge-role-admin     { background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
</style>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;">
    <div>
        <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0;">User Management</h1>
        <p style="color:#64748b;font-size:0.9rem;margin:0.2rem 0 0;">Manage all registered users and their roles.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" style="padding:0.65rem 1.25rem;background:#ede9fe;color:#7C3AED;border-radius:10px;font-weight:700;font-size:0.85rem;text-decoration:none;">← Back to Admin</a>
</div>

@if(session('success'))
    <div style="background:#d1fae5;border:1px solid #a7f3d0;border-radius:12px;padding:0.875rem 1.25rem;margin-bottom:1.5rem;color:#065f46;font-weight:600;font-size:0.9rem;">
        ✓ {{ session('success') }}
    </div>
@endif

<div class="users-card">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#faf5ff;border-bottom:2px solid #f0eaff;">
                <th style="text-align:left;padding:1rem 1.5rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;letter-spacing:0.06em;font-weight:800;">User</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;letter-spacing:0.06em;font-weight:800;">Role</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;letter-spacing:0.06em;font-weight:800;">Applications</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;letter-spacing:0.06em;font-weight:800;">Joined</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;letter-spacing:0.06em;font-weight:800;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr style="border-bottom:1px solid #fafafa;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='white'">
                <td style="padding:1rem 1.5rem;">
                    <div style="display:flex;align-items:center;gap:0.875rem;">
                        @if($u->avatar)
                            <img src="{{ Storage::url($u->avatar) }}" style="width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid #ddd6fe;">
                        @else
                            <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:1rem;flex-shrink:0;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p style="font-weight:800;color:#1e1b4b;margin:0;font-size:0.9rem;">{{ $u->name }}</p>
                            <p style="color:#94a3b8;margin:0;font-size:0.78rem;">{{ $u->email }}</p>
                        </div>
                    </div>
                </td>
                <td style="padding:1rem;"><span class="badge-role-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                <td style="padding:1rem;font-size:0.875rem;color:#475569;font-weight:600;">{{ $u->candidates_count }}</td>
                <td style="padding:1rem;font-size:0.82rem;color:#94a3b8;">{{ $u->created_at->format('M d, Y') }}</td>
                <td style="padding:1rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        @if($u->id !== auth()->id() && $u->role !== 'admin')
                        <form method="POST" action="{{ route('admin.users.toggle-role', $u->id) }}">
                            @csrf @method('PATCH')
                            <button style="padding:4px 12px;border-radius:8px;font-size:0.78rem;font-weight:700;border:1.5px solid #ddd6fe;background:#ede9fe;color:#7C3AED;cursor:pointer;font-family:'Outfit';">
                                Make {{ $u->role === 'hr' ? 'Candidate' : 'HR' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete this user permanently?')">
                            @csrf @method('DELETE')
                            <button style="padding:4px 12px;border-radius:8px;font-size:0.78rem;font-weight:700;border:1.5px solid #fecdd3;background:#fff1f2;color:#dc2626;cursor:pointer;font-family:'Outfit';">Delete</button>
                        </form>
                        @else
                            <span style="font-size:0.78rem;color:#94a3b8;font-style:italic;">Protected</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:1rem 1.5rem;border-top:1px solid #f0eaff;">{{ $users->links() }}</div>
</div>

@endsection
