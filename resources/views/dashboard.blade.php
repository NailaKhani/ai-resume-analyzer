@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<style>
    .dash-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #f0eaff;
        box-shadow: 0 2px 12px rgba(124,58,237,0.06);
        transition: box-shadow 0.25s, transform 0.25s;
    }
    .dash-card:hover {
        box-shadow: 0 8px 28px rgba(124,58,237,0.12);
        transform: translateY(-2px);
    }
    .stat-number {
        font-size: 2.75rem;
        font-weight: 900;
        line-height: 1;
        letter-spacing: -0.03em;
    }
    .progress-bar-track {
        height: 10px;
        background: #ede9fe;
        border-radius: 99px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, #7C3AED, #C084FC);
        transition: width 1s ease;
    }
    .job-tag {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.03em;
    }
    .tag-mid    { background: #dbeafe; color: #1d4ed8; }
    .tag-senior { background: #fef3c7; color: #92400e; }
    .tag-entry  { background: #d1fae5; color: #065f46; }
    .apply-btn {
        display: block;
        text-align: center;
        padding: 0.65rem 1rem;
        border-radius: 10px;
        background: linear-gradient(135deg, #7C3AED, #C084FC);
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(124,58,237,0.25);
        transition: opacity 0.2s, transform 0.2s;
    }
    .apply-btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .activity-card {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.9rem 1rem;
        background: #faf5ff;
        border: 1px solid #ede9fe;
        border-radius: 12px;
        transition: background 0.2s;
    }
    .activity-card:hover { background: #f3e8ff; }
</style>

{{-- ─────────────── WELCOME BANNER ─────────────── --}}
<div style="border-radius:20px;padding:2.75rem 3rem;margin-bottom:1.75rem;background:linear-gradient(130deg,#2E1065 0%,#5B21B6 45%,#9333EA 75%,#C084FC 100%);position:relative;overflow:hidden;">
    {{-- decorative orbs --}}
    <div style="position:absolute;right:-80px;top:-80px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,0.06);pointer-events:none;"></div>
    <div style="position:absolute;right:120px;bottom:-60px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.04);pointer-events:none;"></div>
    <div style="position:relative;z-index:2;">
        <span style="display:inline-block;padding:3px 12px;border-radius:99px;background:rgba(255,255,255,0.15);color:#ddd6fe;font-size:0.72rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:0.75rem;">
            {{ ucfirst(auth()->user()->role) }} Dashboard
        </span>
        <h1 style="color:white;font-size:2.5rem;font-weight:900;margin:0 0 0.5rem;letter-spacing:-0.025em;line-height:1.15;">
            Welcome back, {{ auth()->user()->name }}!
        </h1>
        <p style="color:#ddd6fe;font-size:1rem;margin:0;max-width:520px;line-height:1.6;">
            @if(auth()->user()->role !== 'candidate')
                Manage your job postings and review AI-analyzed candidate applications.
            @else
                Browse open positions and track your AI match scores below.
            @endif
        </p>
    </div>
</div>

{{-- ─────────────── 3 STAT CARDS ─────────────── --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:1.75rem;">

    @if(auth()->user()->role !== 'candidate')
        <x-stat-card title="Active Job Postings" value="{{ $totalJobs }}" color="#6d28d9">
            <x-slot name="icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card title="Total Applications" value="{{ $totalCandidates }}" color="#a855f7">
            <x-slot name="icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card title="Avg. AI Match Score" value="{{ $avgScore }}%" color="#059669">
            <x-slot name="icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </x-slot>
        </x-stat-card>
    @else
        <x-stat-card title="Open Positions" value="{{ $totalJobs }}" color="#6d28d9">
            <x-slot name="icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card title="My Applications" value="{{ $myApplications }}" color="#a855f7">
            <x-slot name="icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card title="Best Match Score" value="{{ $bestScore }}%" color="#059669">
            <x-slot name="icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </x-slot>
        </x-stat-card>
    @endif

</div>

{{-- ─────────────── HR: CHARTS ─────────────── --}}
@if(auth()->user()->role !== 'candidate')
<div style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;margin-bottom:1.75rem;">
    <div class="dash-card" style="padding:1.5rem;">
        <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0 0 1rem;">Applications per Job</h2>
        <canvas id="hrAppsChart" height="200"></canvas>
    </div>
    <div class="dash-card" style="padding:1.5rem;">
        <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0 0 1rem;">Candidate Status</h2>
        <div style="display:flex;align-items:center;justify-content:center;">
            <canvas id="hrStatusChart" height="200" style="max-width:240px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // HR Dashboard: Applications per job
        const hrAppsData = @json($applicationsPerJob ?? []);
        if(document.getElementById('hrAppsChart') && hrAppsData.length > 0) {
            new Chart(document.getElementById('hrAppsChart'), {
                type: 'bar',
                data: {
                    labels: hrAppsData.map(d => d.label),
                    datasets: [{
                        label: 'Applicants',
                        data: hrAppsData.map(d => d.value),
                        backgroundColor: 'rgba(124,58,237,0.7)',
                        borderRadius: 6
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        }

        // HR Dashboard: Status Distribution
        const hrStatusData = @json($statusDistribution ?? []);
        const hrStatusColors = { 'Pending':'#c4b5fd', 'Screened':'#93c5fd', 'Shortlisted':'#6ee7b7', 'Interviewed':'#fcd34d', 'Rejected':'#fca5a5' };
        if(document.getElementById('hrStatusChart') && hrStatusData.length > 0) {
            new Chart(document.getElementById('hrStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: hrStatusData.map(d => d.label),
                    datasets: [{
                        data: hrStatusData.map(d => d.value),
                        backgroundColor: hrStatusData.map(d => hrStatusColors[d.label] || '#e2e8f0'),
                        borderWidth: 2
                    }]
                },
                options: { responsive: true, cutout: '65%' }
            });
        }
    });
</script>

{{-- ─────────────── HR: RECENT APPLICATIONS TABLE ─────────────── --}}
<div class="dash-card" style="overflow:hidden;margin-bottom:1.75rem;">
    <div style="padding:1.25rem 1.75rem;border-bottom:1px solid #f5f3ff;display:flex;justify-content:space-between;align-items:center;">
        <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Recent Applications</h2>
        <a href="{{ route('candidates.index') }}" style="font-size:0.82rem;color:#7C3AED;font-weight:700;text-decoration:none;">View All &rarr;</a>
    </div>
    @if($recentCandidates->isEmpty())
        <div style="padding:3rem;text-align:center;">
            <p style="color:#94a3b8;margin:0;">No applications yet.</p>
        </div>
    @else
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#faf5ff;">
                <th style="padding:0.875rem 1.75rem;text-align:left;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;border-bottom:1px solid #f0eaff;">Candidate</th>
                <th style="padding:0.875rem 1.75rem;text-align:left;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;border-bottom:1px solid #f0eaff;">Applied For</th>
                <th style="padding:0.875rem 1.75rem;text-align:left;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;border-bottom:1px solid #f0eaff;">AI Score</th>
                <th style="padding:0.875rem 1.75rem;text-align:left;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;border-bottom:1px solid #f0eaff;">Applied</th>
                <th style="padding:0.875rem 1.75rem;text-align:left;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;border-bottom:1px solid #f0eaff;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentCandidates as $c)
            <tr style="border-bottom:1px solid #faf5ff;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='white'">
                <td style="padding:1rem 1.75rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;">
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#C084FC);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:0.82rem;flex-shrink:0;">{{ strtoupper(substr($c->user->name,0,1)) }}</div>
                        <div>
                            <p style="font-weight:700;color:#1e1b4b;margin:0;font-size:0.875rem;">{{ $c->user->name }}</p>
                            <p style="color:#94a3b8;margin:0;font-size:0.75rem;">{{ $c->user->email }}</p>
                        </div>
                    </div>
                </td>
                <td style="padding:1rem 1.75rem;font-size:0.875rem;color:#334155;font-weight:500;">{{ $c->jobPosting->title ?? '–' }}</td>
                <td style="padding:1rem 1.75rem;">
                    @if($c->match_score !== null)
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <div class="progress-bar-track" style="width:72px;"><div class="progress-bar-fill" style="width:{{ min($c->match_score,100) }}%;"></div></div>
                            <span style="font-size:0.8rem;font-weight:800;color:#7C3AED;">{{ number_format($c->match_score,1) }}%</span>
                        </div>
                    @else
                        <span style="font-size:0.75rem;background:#f1f5f9;color:#94a3b8;padding:3px 10px;border-radius:99px;font-weight:600;">Pending AI</span>
                    @endif
                </td>
                <td style="padding:1rem 1.75rem;font-size:0.82rem;color:#64748b;">{{ $c->created_at->diffForHumans() }}</td>
                <td style="padding:1rem 1.75rem;">
                    <a href="{{ route('candidates.show',$c->id) }}" style="padding:0.4rem 0.9rem;border-radius:8px;background:#ede9fe;color:#7C3AED;border:1px solid #ddd6fe;font-size:0.78rem;font-weight:700;text-decoration:none;" onmouseover="this.style.background='#ddd6fe'" onmouseout="this.style.background='#ede9fe'">Review</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // HR Dashboard: Applications per job
    const hrAppsData = @json($applicationsPerJob);
    if(document.getElementById('hrAppsChart')) {
        new Chart(document.getElementById('hrAppsChart'), {
            type: 'bar',
            data: {
                labels: hrAppsData.map(d => d.label),
                datasets: [{
                    label: 'Applicants',
                    data: hrAppsData.map(d => d.value),
                    backgroundColor: 'rgba(124,58,237,0.7)',
                    borderRadius: 6
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    }

    // HR Dashboard: Status Distribution
    const hrStatusData = @json($statusDistribution);
    const hrStatusColors = { 'Pending':'#c4b5fd', 'Screened':'#93c5fd', 'Shortlisted':'#6ee7b7', 'Interviewed':'#fcd34d', 'Rejected':'#fca5a5' };
    if(document.getElementById('hrStatusChart')) {
        new Chart(document.getElementById('hrStatusChart'), {
            type: 'doughnut',
            data: {
                labels: hrStatusData.map(d => d.label),
                datasets: [{
                    data: hrStatusData.map(d => d.value),
                    backgroundColor: hrStatusData.map(d => hrStatusColors[d.label] || '#e2e8f0'),
                    borderWidth: 2
                }]
            },
            options: { responsive: true, cutout: '65%' }
        });
    }
</script>

@else
{{-- ─────────────── CANDIDATE: LATEST JOBS 3-COLUMN GRID ─────────────── --}}
<div class="dash-card" style="overflow:hidden;margin-bottom:1.75rem;">
    <div style="padding:1.25rem 1.75rem;border-bottom:1px solid #f5f3ff;display:flex;justify-content:space-between;align-items:center;">
        <h2 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Latest Open Positions</h2>
        <a href="{{ route('candidates.index') }}" style="font-size:0.82rem;color:#7C3AED;font-weight:700;text-decoration:none;">Browse All &rarr;</a>
    </div>

    <div style="padding:1.5rem;display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
        @forelse($latestJobs as $job)
            <x-job-card :job="$job" role="candidate" />
        @empty
        <div style="grid-column:1/-1;padding:3rem;text-align:center;">
            <p style="color:#94a3b8;margin:0;">No open positions right now.</p>
        </div>
        @endforelse

        {{-- Fill to at least 3 columns --}}
        @for($i = count($latestJobs); $i < 3 && $i < 3; $i++)
        <div style="background:#faf5ff;border:1.5px dashed #ddd6fe;border-radius:14px;padding:1.5rem;display:flex;align-items:center;justify-content:center;opacity:0.4;">
            <p style="color:#c4b5fd;font-size:0.82rem;font-weight:600;margin:0;text-align:center;">More positions coming soon</p>
        </div>
        @endfor
    </div>
</div>

{{-- ─────────────── BOTTOM 2-COLUMN WIDGETS ─────────────── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

    {{-- LEFT: Resume Strength --}}
    <div class="dash-card" style="padding:1.75rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
            <h3 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Your Resume Strength</h3>
            @if($myApplications > 0)
                <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:99px;background:#d1fae5;color:#065f46;">Active</span>
            @endif
        </div>

        @if($myApplications > 0)
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            {{-- Best Score --}}
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                    <span style="font-size:0.85rem;color:#475569;font-weight:600;">Best AI Match Score</span>
                    <span style="font-size:0.85rem;font-weight:800;color:#7C3AED;">{{ $bestScore }}%</span>
                </div>
                <div class="progress-bar-track">
                    <div class="progress-bar-fill" style="width:{{ min($bestScore,100) }}%;"></div>
                </div>
            </div>
            {{-- Applications Progress --}}
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                    <span style="font-size:0.85rem;color:#475569;font-weight:600;">Applications Submitted</span>
                    <span style="font-size:0.85rem;font-weight:800;color:#9333ea;">{{ $myApplications }}</span>
                </div>
                <div class="progress-bar-track" style="background:#fae8ff;">
                    <div class="progress-bar-fill" style="width:{{ min($myApplications*20,100) }}%;background:linear-gradient(90deg,#9333ea,#ec4899);"></div>
                </div>
            </div>
            {{-- Profile Completeness --}}
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                    <span style="font-size:0.85rem;color:#475569;font-weight:600;">Profile Completeness</span>
                    <span style="font-size:0.85rem;font-weight:800;color:#7C3AED;">{{ auth()->user()->calculateProfileCompleteness() }}%</span>
                </div>
                <div class="progress-bar-track">
                    <div class="progress-bar-fill" style="width:{{ auth()->user()->calculateProfileCompleteness() }}%;"></div>
                </div>
            </div>

            <div style="background:#faf5ff;border:1px solid #ede9fe;border-radius:10px;padding:0.875rem;margin-top:0.25rem;">
                <p style="font-size:0.8rem;color:#64748b;margin:0;line-height:1.5;">
                    💡 <strong style="color:#7C3AED;">Tip:</strong> Upload an updated resume to improve your match score on new applications.
                </p>
            </div>
        </div>
        @else
        <div style="text-align:center;padding:2.5rem 1rem;">
            <div style="width:56px;height:56px;border-radius:14px;background:#ede9fe;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg width="28" height="28" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p style="color:#64748b;font-size:0.875rem;margin:0 0 1rem;">Apply to jobs to see your resume strength score here.</p>
            <a href="{{ route('candidates.index') }}" class="apply-btn" style="display:inline-block;padding:0.6rem 1.4rem;">Browse Jobs</a>
        </div>
        @endif
    </div>

    {{-- RIGHT: Recent Activity --}}
    <div class="dash-card" style="padding:1.75rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
            <h3 style="font-size:1.05rem;font-weight:800;color:#1e1b4b;margin:0;">Recent Activity</h3>
            <a href="{{ route('candidates.my') }}" style="font-size:0.78rem;color:#7C3AED;font-weight:700;text-decoration:none;">View All &rarr;</a>
        </div>

        @if($recentApplications->isEmpty())
        <div style="text-align:center;padding:2.5rem 1rem;">
            <div style="width:56px;height:56px;border-radius:14px;background:#ede9fe;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg width="28" height="28" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p style="color:#64748b;font-size:0.875rem;margin:0;">No recent activity. Start applying to see your history here.</p>
        </div>
        @else
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
            @foreach($recentApplications as $app)
            <div class="activity-card">
                <div style="width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,#ede9fe,#fae8ff);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:0.875rem;font-weight:700;color:#1e1b4b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $app->jobPosting->title ?? 'Job Application' }}</p>
                    <p style="font-size:0.75rem;color:#94a3b8;margin:0.15rem 0 0;">Applied {{ $app->created_at->diffForHumans() }}</p>
                </div>
                @if($app->match_score !== null)
                <div style="text-align:right;flex-shrink:0;">
                    <span style="font-size:0.9rem;font-weight:900;color:#7C3AED;">{{ number_format($app->match_score,1) }}%</span>
                    <p style="font-size:0.68rem;color:#94a3b8;margin:0;">match</p>
                </div>
                @else
                <span style="font-size:0.72rem;background:#f1f5f9;color:#94a3b8;padding:3px 8px;border-radius:99px;flex-shrink:0;font-weight:600;">Pending</span>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
@endif

@endsection
