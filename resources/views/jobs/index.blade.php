@extends('layouts.app')
@section('title', 'Job Postings')

@section('content')

<style>
    .page-card { background:white; border-radius:16px; border:1px solid #f0eaff; box-shadow:0 2px 12px rgba(124,58,237,0.06); }
    .page-card:hover { box-shadow:0 8px 28px rgba(124,58,237,0.1); }
    .badge-entry  { background:#d1fae5; color:#065f46; }
    .badge-mid    { background:#dbeafe; color:#1d4ed8; }
    .badge-senior { background:#fef3c7; color:#92400e; }
    .badge-default{ background:#f1f5f9; color:#475569; }
    .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-size:0.72rem; font-weight:700; }
    .action-btn { padding:0.45rem 1rem; border-radius:8px; font-size:0.82rem; font-weight:700; text-decoration:none; border:1.5px solid; transition:background 0.2s; }
    .search-input { width:100%; padding:0.7rem 1rem; border-radius:10px; border:1.5px solid #e2e8f0; background:#faf5ff; font-size:0.875rem; outline:none; font-family:'Outfit',sans-serif; transition:border 0.2s, box-shadow 0.2s; box-sizing:border-box; }
    .search-input:focus { border-color:#7C3AED; box-shadow:0 0 0 3px rgba(124,58,237,0.1); }
</style>

{{-- Page Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0 0 0.25rem;letter-spacing:-0.02em;">Job Postings</h1>
        <p style="color:#64748b;margin:0;font-size:0.9rem;">Browse and manage all open positions.</p>
    </div>
    @if(auth()->user()->role !== 'candidate')
        <a href="{{ route('jobs.create') }}"
            style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.5rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;font-size:0.9rem;text-decoration:none;box-shadow:0 4px 14px rgba(124,58,237,0.3);">
            <span style="font-size:1.2rem;line-height:1;">+</span> Post New Job
        </a>
    @endif
</div>

{{-- Search/Filter --}}
<div class="page-card" style="padding:1.25rem 1.5rem;margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('jobs.index') }}">
        <div style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:1;min-width:220px;">
                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.4rem;">Search Jobs</label>
                <input type="text" name="search" class="search-input" placeholder="Title, skills, keyword..." value="{{ request('search') }}">
            </div>
            <div style="min-width:160px;">
                <label style="display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.4rem;">Experience Level</label>
                <select name="experience" class="search-input" style="cursor:pointer;">
                    <option value="">All Levels</option>
                    <option value="entry" {{ request('experience') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                    <option value="mid" {{ request('experience') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                    <option value="senior" {{ request('experience') === 'senior' ? 'selected' : '' }}>Senior Level</option>
                </select>
            </div>
            <div style="display:flex;gap:0.75rem;align-items:center;">
                <button type="submit" style="padding:0.7rem 1.5rem;border-radius:10px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:700;font-size:0.875rem;border:none;cursor:pointer;font-family:'Outfit',sans-serif;">Search</button>
                @if(request('search') || request('experience'))
                    <a href="{{ route('jobs.index') }}" style="padding:0.7rem 1.25rem;border-radius:10px;border:1.5px solid #e2e8f0;color:#64748b;font-weight:600;font-size:0.875rem;text-decoration:none;">Clear</a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Jobs List --}}
@if($jobs->isEmpty())
    <div class="page-card" style="padding:4rem;text-align:center;">
        <div style="width:64px;height:64px;background:#ede9fe;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <svg width="32" height="32" fill="none" stroke="#7C3AED" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h3 style="font-size:1.2rem;font-weight:700;color:#1e1b4b;margin:0 0 0.5rem;">No job postings found</h3>
        <p style="color:#94a3b8;font-size:0.9rem;margin:0;">Try adjusting your search or post a new job.</p>
    </div>
@else
    <div style="display:flex;flex-direction:column;gap:1rem;">
        @foreach($jobs as $job)
        @php
            $badgeClass = ['entry'=>'badge-entry','mid'=>'badge-mid','senior'=>'badge-senior'][$job->experience_level] ?? 'badge-default';
        @endphp
        <div class="page-card" style="padding:1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;transition:box-shadow 0.25s,transform 0.25s;" onmouseover="this.style.boxShadow='0 8px 28px rgba(124,58,237,0.1)';this.style.transform='translateY(-1px)'" onmouseout="this.style.boxShadow='';this.style.transform='translateY(0)'">
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;margin-bottom:0.5rem;">
                    <h3 style="font-size:1rem;font-weight:800;color:#1e1b4b;margin:0;">{{ $job->title }}</h3>
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($job->experience_level) }}</span>
                    @if(auth()->user()->role !== 'candidate')
                        <span class="badge" style="background:#ede9fe;color:#7C3AED;">{{ $job->candidates->count() }} Applicants</span>
                    @endif
                </div>
                <p style="color:#64748b;font-size:0.875rem;margin:0 0 0.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:600px;">{{ $job->required_skills }}</p>
                <p style="color:#94a3b8;font-size:0.78rem;margin:0;">Posted {{ $job->created_at->diffForHumans() }}</p>
            </div>
            <div style="display:flex;align-items:center;gap:0.75rem;flex-shrink:0;">
                <a href="{{ route('jobs.show', $job->id) }}" class="action-btn" style="background:#ede9fe;color:#7C3AED;border-color:#ddd6fe;" onmouseover="this.style.background='#ddd6fe'" onmouseout="this.style.background='#ede9fe'">View</a>
                @if(auth()->user()->role !== 'candidate')
                    <a href="{{ route('jobs.edit', $job->id) }}" class="action-btn" style="background:#f8fafc;color:#475569;border-color:#e2e8f0;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">Edit</a>
                    <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" onsubmit="return confirm('Delete this job posting?')">
                        @csrf @method('DELETE')
                        <button class="action-btn" style="background:#fff1f2;color:#dc2626;border-color:#fecdd3;cursor:pointer;font-family:'Outfit',sans-serif;" onmouseover="this.style.background='#fecdd3'" onmouseout="this.style.background='#fff1f2'">Delete</button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div style="margin-top:1.5rem;">{{ $jobs->links() }}</div>
@endif

@endsection
