@extends('layouts.app')
@section('title', 'Admin Panel')

@section('content')

<style>
    .admin-stat { background:white; border-radius:18px; padding:1.5rem; border:1px solid #f0eaff; box-shadow:0 2px 12px rgba(124,58,237,0.06); }
    .admin-card { background:white; border-radius:18px; border:1px solid #f0eaff; box-shadow:0 2px 12px rgba(124,58,237,0.06); overflow:hidden; margin-bottom:1.5rem; }
    .admin-card-header { padding:1.25rem 1.5rem; border-bottom:1px solid #f5f3ff; display:flex; justify-content:space-between; align-items:center; }
    .admin-card-body { padding:1.5rem; }
    .badge-role-hr        { background:#dbeafe; color:#1d4ed8; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .badge-role-candidate { background:#ede9fe; color:#7C3AED; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .badge-role-admin     { background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .action-link { font-size:0.8rem; font-weight:700; text-decoration:none; padding:4px 12px; border-radius:8px; border:1.5px solid; transition:background 0.2s; }
</style>

{{-- Page Header --}}
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
    <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#f59e0b,#ef4444);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(245,158,11,0.3);">
        <svg width="26" height="26" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
    </div>
    <div>
        <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0;">Admin Panel</h1>
        <p style="color:#64748b;font-size:0.9rem;margin:0;">System-wide overview and management.</p>
    </div>
    <div style="margin-left:auto;display:flex;gap:0.75rem;">
        <a href="{{ route('admin.users') }}" style="padding:0.6rem 1.25rem;background:#ede9fe;color:#7C3AED;border-radius:10px;font-weight:700;font-size:0.85rem;text-decoration:none;">Manage Users</a>
        <a href="{{ route('admin.activity') }}" style="padding:0.6rem 1.25rem;background:#1e1b4b;color:white;border-radius:10px;font-weight:700;font-size:0.85rem;text-decoration:none;">Activity Logs</a>
    </div>
</div>

{{-- Stats Grid --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:1.5rem;">
    <div class="admin-stat">
        <div style="width:44px;height:44px;border-radius:12px;background:#ede9fe;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
            <svg width="22" height="22" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p style="font-size:2rem;font-weight:900;color:#1e1b4b;margin:0;">{{ $stats['total_users'] }}</p>
        <p style="font-size:0.85rem;color:#64748b;margin:0.2rem 0 0;font-weight:600;">Total Users</p>
    </div>
    <div class="admin-stat">
        <div style="width:44px;height:44px;border-radius:12px;background:#dbeafe;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
            <svg width="22" height="22" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <p style="font-size:2rem;font-weight:900;color:#1e1b4b;margin:0;">{{ $stats['total_jobs'] }}</p>
        <p style="font-size:0.85rem;color:#64748b;margin:0.2rem 0 0;font-weight:600;">Job Postings</p>
    </div>
    <div class="admin-stat">
        <div style="width:44px;height:44px;border-radius:12px;background:#d1fae5;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
            <svg width="22" height="22" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <p style="font-size:2rem;font-weight:900;color:#1e1b4b;margin:0;">{{ $stats['total_apps'] }}</p>
        <p style="font-size:0.85rem;color:#64748b;margin:0.2rem 0 0;font-weight:600;">Total Applications</p>
    </div>
    <div class="admin-stat">
        <div style="width:44px;height:44px;border-radius:12px;background:#fef3c7;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
            <svg width="22" height="22" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <p style="font-size:2rem;font-weight:900;color:#1e1b4b;margin:0;">{{ $stats['avg_score'] }}%</p>
        <p style="font-size:0.85rem;color:#64748b;margin:0.2rem 0 0;font-weight:600;">Avg AI Match Score</p>
    </div>
</div>

{{-- Charts Row --}}
<div style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
    {{-- Applications per day chart --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 style="font-size:1rem;font-weight:800;color:#1e1b4b;margin:0;">Applications (Last 7 Days)</h3>
        </div>
        <div class="admin-card-body">
            <canvas id="appsChart" height="180"></canvas>
        </div>
    </div>

    {{-- Status Doughnut --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 style="font-size:1rem;font-weight:800;color:#1e1b4b;margin:0;">Candidate Status Breakdown</h3>
        </div>
        <div class="admin-card-body" style="display:flex;align-items:center;justify-content:center;">
            <canvas id="statusChart" height="180" style="max-width:220px;"></canvas>
        </div>
    </div>
</div>

{{-- Bottom Row: Users + Activity --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    {{-- Recent Users --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 style="font-size:1rem;font-weight:800;color:#1e1b4b;margin:0;">Recent Users</h3>
            <a href="{{ route('admin.users') }}" style="font-size:0.8rem;color:#7C3AED;font-weight:700;text-decoration:none;">View All →</a>
        </div>
        <div class="admin-card-body" style="padding:0;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid #f5f3ff;">
                        <th style="text-align:left;padding:0.75rem 1.25rem;font-size:0.72rem;color:#94a3b8;text-transform:uppercase;font-weight:700;">Name</th>
                        <th style="text-align:left;padding:0.75rem;font-size:0.72rem;color:#94a3b8;text-transform:uppercase;font-weight:700;">Role</th>
                        <th style="text-align:left;padding:0.75rem;font-size:0.72rem;color:#94a3b8;text-transform:uppercase;font-weight:700;">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users->take(5) as $u)
                    <tr style="border-bottom:1px solid #fafafa;">
                        <td style="padding:0.875rem 1.25rem;">
                            <div style="display:flex;align-items:center;gap:0.75rem;">
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:0.9rem;flex-shrink:0;">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p style="font-weight:700;color:#1e1b4b;margin:0;font-size:0.875rem;">{{ $u->name }}</p>
                                    <p style="color:#94a3b8;margin:0;font-size:0.75rem;">{{ $u->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:0.875rem;">
                            <span class="badge-role-{{ $u->role }}">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td style="padding:0.875rem;font-size:0.8rem;color:#94a3b8;">{{ $u->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 style="font-size:1rem;font-weight:800;color:#1e1b4b;margin:0;">Recent Activity</h3>
            <a href="{{ route('admin.activity') }}" style="font-size:0.8rem;color:#7C3AED;font-weight:700;text-decoration:none;">View All →</a>
        </div>
        <div class="admin-card-body" style="display:flex;flex-direction:column;gap:0.75rem;">
            @forelse($recentActivity as $log)
            <div style="display:flex;align-items:flex-start;gap:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid #fafafa;">
                <div style="width:34px;height:34px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:0.82rem;font-weight:700;color:#1e1b4b;margin:0;">{{ $log->action }}</p>
                    <p style="font-size:0.75rem;color:#64748b;margin:0.1rem 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $log->description }}</p>
                    <p style="font-size:0.7rem;color:#94a3b8;margin:0.1rem 0 0;">{{ $log->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p style="color:#94a3b8;font-size:0.875rem;text-align:center;padding:1rem 0;">No activity logged yet.</p>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Applications per day
    const appsData = @json($applicationsPerDay);
    new Chart(document.getElementById('appsChart'), {
        type: 'bar',
        data: {
            labels: appsData.map(d => d.date),
            datasets: [{
                label: 'Applications',
                data: appsData.map(d => d.total),
                backgroundColor: 'rgba(124,58,237,0.7)',
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f5f3ff' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Status doughnut
    const statusColors = {
        'Pending': '#c4b5fd', 'Screened': '#93c5fd', 'Shortlisted': '#6ee7b7',
        'Interviewed': '#fcd34d', 'Rejected': '#fca5a5'
    };
    const statusData = @json($statusDist);
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusData.map(d => d.label),
            datasets: [{
                data: statusData.map(d => d.value),
                backgroundColor: statusData.map(d => statusColors[d.label] || '#e2e8f0'),
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Outfit', size: 11 } } }
            },
            cutout: '65%'
        }
    });
</script>

@endsection
