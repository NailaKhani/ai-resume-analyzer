@extends('layouts.app')
@section('title', 'Activity Audit Trail')

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0 0 0.4rem 0;">Activity Audit Trail</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Real-time log of system events, applications, and role changes.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" style="padding: 0.65rem 1.4rem; background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE; border-radius: 50px; font-weight: 800; font-size: 0.88rem; text-decoration: none;">
        ← Back to Admin Overview
    </a>
</div>

<div class="glass-card" style="overflow: hidden;">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Action Type</th>
                <th>User Account</th>
                <th>Description</th>
                <th>IP Address</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            @php
                $chipStyle = match(true) {
                    str_contains($log->action, 'Applied') => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                    str_contains($log->action, 'Status')  => ['bg' => '#DBEAFE', 'text' => '#1D4ED8'],
                    str_contains($log->action, 'Created') => ['bg' => '#EEF2FF', 'text' => '#4F46E5'],
                    str_contains($log->action, 'Deleted') => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
                    default => ['bg' => '#F1F5F9', 'text' => '#475569'],
                };
            @endphp
            <tr>
                <td>
                    <span style="padding: 4px 12px; background: {{ $chipStyle['bg'] }}; color: {{ $chipStyle['text'] }}; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                        {{ $log->action }}
                    </span>
                </td>
                <td>
                    <p style="font-size: 0.9rem; font-weight: 800; color: #0F172A; margin: 0;">{{ $log->user->name ?? 'System User' }}</p>
                    <p style="font-size: 0.78rem; color: #64748B; margin: 0;">{{ $log->user->email ?? '' }}</p>
                </td>
                <td style="color: #334155; font-size: 0.88rem; max-width: 320px;">{{ $log->description }}</td>
                <td style="color: #64748B; font-family: monospace; font-size: 0.82rem;">{{ $log->ip_address }}</td>
                <td style="color: #64748B; font-size: 0.82rem; font-weight: 600;">{{ $log->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 3rem; text-align: center; color: #94A3B8; font-size: 0.9rem;">
                    No activity logged yet. System operations will automatically create audit logs here.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($logs->hasPages())
        <div style="padding: 1.25rem 1.5rem; border-top: 1px solid #E2E8F0; background: #FAFAFA;">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
