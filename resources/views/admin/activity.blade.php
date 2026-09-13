@extends('layouts.app')
@section('title', 'Activity Logs')

@section('content')

<style>
    .log-card { background:white; border-radius:18px; border:1px solid #f0eaff; box-shadow:0 2px 12px rgba(124,58,237,0.06); overflow:hidden; }
    .action-chip { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .chip-applied  { background:#d1fae5; color:#065f46; }
    .chip-status   { background:#dbeafe; color:#1d4ed8; }
    .chip-created  { background:#ede9fe; color:#7C3AED; }
    .chip-deleted  { background:#fee2e2; color:#991b1b; }
    .chip-default  { background:#f1f5f9; color:#475569; }
</style>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;">
    <div>
        <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0;">Activity Logs</h1>
        <p style="color:#64748b;font-size:0.9rem;margin:0.2rem 0 0;">A complete audit trail of all system actions.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" style="padding:0.65rem 1.25rem;background:#ede9fe;color:#7C3AED;border-radius:10px;font-weight:700;font-size:0.85rem;text-decoration:none;">← Back to Admin</a>
</div>

<div class="log-card">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#faf5ff;border-bottom:2px solid #f0eaff;">
                <th style="text-align:left;padding:1rem 1.5rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;font-weight:800;">Action</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;font-weight:800;">User</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;font-weight:800;">Description</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;font-weight:800;">IP</th>
                <th style="text-align:left;padding:1rem;font-size:0.78rem;color:#7C3AED;text-transform:uppercase;font-weight:800;">When</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            @php
                $chipClass = match(true) {
                    str_contains($log->action, 'Applied') => 'chip-applied',
                    str_contains($log->action, 'Status')  => 'chip-status',
                    str_contains($log->action, 'Created') => 'chip-created',
                    str_contains($log->action, 'Deleted') => 'chip-deleted',
                    default => 'chip-default',
                };
            @endphp
            <tr style="border-bottom:1px solid #fafafa;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='white'">
                <td style="padding:1rem 1.5rem;">
                    <span class="action-chip {{ $chipClass }}">{{ $log->action }}</span>
                </td>
                <td style="padding:1rem;">
                    <p style="font-size:0.875rem;font-weight:700;color:#1e1b4b;margin:0;">{{ $log->user->name ?? 'Unknown' }}</p>
                    <p style="font-size:0.75rem;color:#94a3b8;margin:0;">{{ $log->user->email ?? '' }}</p>
                </td>
                <td style="padding:1rem;font-size:0.82rem;color:#475569;max-width:300px;">{{ $log->description }}</td>
                <td style="padding:1rem;font-size:0.78rem;color:#94a3b8;font-family:monospace;">{{ $log->ip_address }}</td>
                <td style="padding:1rem;font-size:0.78rem;color:#94a3b8;">{{ $log->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="padding:3rem;text-align:center;color:#94a3b8;font-size:0.875rem;">No activity logged yet. Actions like job creation and applications will appear here.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:1rem 1.5rem;border-top:1px solid #f0eaff;">{{ $logs->links() }}</div>
</div>

@endsection
