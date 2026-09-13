@extends('layouts.app')
@section('title', 'My Applications')

@section('content')

<style>
    .page-card { background:white; border-radius:16px; border:1px solid #f0eaff; box-shadow:0 2px 12px rgba(124,58,237,0.06); }
    .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .badge-entry  { background:#d1fae5; color:#065f46; }
    .badge-mid    { background:#dbeafe; color:#1d4ed8; }
    .badge-senior { background:#fef3c7; color:#92400e; }
    .progress-track { height:8px; background:#ede9fe; border-radius:99px; overflow:hidden; }
    .progress-fill  { height:100%; border-radius:99px; background:linear-gradient(90deg,#7C3AED,#C084FC); }
    .action-btn { padding:0.4rem 0.875rem; border-radius:8px; font-size:0.78rem; font-weight:700; text-decoration:none; border:1.5px solid; transition:background 0.2s; }
</style>

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0 0 0.25rem;letter-spacing:-0.02em;">My Applications</h1>
        <p style="color:#64748b;margin:0;font-size:0.9rem;">Track the status of all your submitted applications.</p>
    </div>
    <a href="{{ route('jobs.index') }}"
        style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.5rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;font-size:0.875rem;text-decoration:none;box-shadow:0 4px 14px rgba(124,58,237,0.25);">
        Browse Jobs
    </a>
</div>

@if($applications->isEmpty())
    <div class="page-card" style="padding:5rem;text-align:center;max-width:520px;margin:0 auto;">
        <div style="width:72px;height:72px;background:#ede9fe;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;transform:rotate(6deg);">
            <svg width="36" height="36" fill="none" stroke="#7C3AED" stroke-width="1.5" viewBox="0 0 24 24" style="transform:rotate(-6deg)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h3 style="font-size:1.4rem;font-weight:800;color:#1e1b4b;margin:0 0 0.5rem;">No applications yet</h3>
        <p style="color:#94a3b8;margin:0 0 1.75rem;font-size:0.9rem;line-height:1.6;">Browse open positions and submit your resume to get started on your career journey.</p>
        <a href="{{ route('jobs.index') }}"
            style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.8rem 2rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(124,58,237,0.3);">
            Find Your Next Job
            <svg width="16" height="16" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
@else
    <div class="page-card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#7C3AED,#C084FC);">
                        <th style="padding:1rem 1.5rem;text-align:left;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.1em;white-space:nowrap;">Position</th>
                        <th style="padding:1rem 1.5rem;text-align:left;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.1em;white-space:nowrap;">Match Score</th>
                        <th style="padding:1rem 1.5rem;text-align:left;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.1em;white-space:nowrap;">Skills Detected</th>
                        <th style="padding:1rem 1.5rem;text-align:left;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.1em;white-space:nowrap;">Applied</th>
                        <th style="padding:1rem 1.5rem;text-align:left;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.1em;white-space:nowrap;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    @php
                        $lvl = $app->jobPosting->experience_level ?? 'mid';
                        $badgeClass = ['entry'=>'badge-entry','mid'=>'badge-mid','senior'=>'badge-senior'][$lvl] ?? '';
                    @endphp
                    <tr style="border-bottom:1px solid #faf5ff;transition:background 0.2s;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='white'">
                        <td style="padding:1.1rem 1.5rem;">
                            <p style="font-weight:800;color:#1e1b4b;margin:0 0 0.4rem;font-size:0.9rem;">{{ $app->jobPosting->title ?? '–' }}</p>
                            @if($app->jobPosting)
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($lvl) }}</span>
                            @endif
                        </td>
                        <td style="padding:1.1rem 1.5rem;">
                            @if($app->match_score !== null)
                                <div style="display:flex;align-items:center;gap:0.6rem;">
                                    <div class="progress-track" style="width:80px;">
                                        <div class="progress-fill" style="width:{{ min($app->match_score,100) }}%;"></div>
                                    </div>
                                    <span style="font-size:0.85rem;font-weight:800;color:#7C3AED;">{{ number_format($app->match_score,1) }}%</span>
                                </div>
                            @else
                                <span style="font-size:0.75rem;background:#f1f5f9;color:#94a3b8;padding:3px 10px;border-radius:99px;font-weight:600;">Analyzing...</span>
                            @endif
                        </td>
                        <td style="padding:1.1rem 1.5rem;">
                            <div style="display:flex;flex-wrap:wrap;gap:0.35rem;max-width:220px;">
                                @if($app->parsed_skills)
                                    @foreach(array_slice((array)$app->parsed_skills, 0, 3) as $skill)
                                        <span style="display:inline-flex;padding:2px 8px;border-radius:6px;background:#ede9fe;color:#7C3AED;font-size:0.72rem;font-weight:700;">{{ $skill }}</span>
                                    @endforeach
                                    @if(count((array)$app->parsed_skills) > 3)
                                        <span style="font-size:0.72rem;color:#94a3b8;align-self:center;">+{{ count((array)$app->parsed_skills) - 3 }} more</span>
                                    @endif
                                @else
                                    <span style="font-size:0.78rem;color:#94a3b8;">Pending</span>
                                @endif
                            </div>
                        </td>
                        <td style="padding:1.1rem 1.5rem;font-size:0.82rem;color:#64748b;white-space:nowrap;">{{ $app->created_at->diffForHumans() }}</td>
                        <td style="padding:1.1rem 1.5rem;">
                            <div style="display:flex;align-items:center;gap:0.6rem;">
                                @if($app->resume_path)
                                    <a href="{{ Storage::url($app->resume_path) }}" target="_blank" class="action-btn" style="background:#ede9fe;color:#7C3AED;border-color:#ddd6fe;" onmouseover="this.style.background='#ddd6fe'" onmouseout="this.style.background='#ede9fe'">Resume</a>
                                @endif
                                <form method="POST" action="{{ route('candidates.destroy', $app->id) }}" onsubmit="return confirm('Withdraw this application?')">
                                    @csrf @method('DELETE')
                                    <button class="action-btn" style="background:#fff1f2;color:#dc2626;border-color:#fecdd3;cursor:pointer;font-family:'Outfit',sans-serif;" onmouseover="this.style.background='#fecdd3'" onmouseout="this.style.background='#fff1f2'">Withdraw</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1rem 1.5rem;border-top:1px solid #f0eaff;">{{ $applications->links() }}</div>
    </div>
@endif

@endsection
