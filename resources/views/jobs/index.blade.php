@extends('layouts.app')
@section('title', 'Browse Job Opportunities')

@section('content')

{{-- Page Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0 0 0.4rem 0;">Browse Job Opportunities</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Explore open positions matched against your resume profile by AI.</p>
    </div>
    @if(auth()->user()->role !== 'candidate')
        <a href="{{ route('jobs.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.6rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 800; font-size: 0.9rem; text-decoration: none; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <span style="font-size: 1.2rem; line-height: 1;">+</span> Post New Job
        </a>
    @endif
</div>

{{-- Search Filter Panel --}}
<div class="glass-card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('jobs.index') }}">
        <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1.2rem; align-items: end;">
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Search Jobs</label>
                <input type="text" name="search" placeholder="Title, required skills, keywords..." value="{{ request('search') }}">
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Experience Level</label>
                <select name="experience">
                    <option value="">All Levels</option>
                    <option value="entry" {{ request('experience') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                    <option value="mid" {{ request('experience') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                    <option value="senior" {{ request('experience') === 'senior' ? 'selected' : '' }}>Senior Level</option>
                </select>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="padding: 0.65rem 1.6rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; border: none; border-radius: 12px; font-weight: 800; font-size: 0.88rem; cursor: pointer;">
                    Search
                </button>
                @if(request('search') || request('experience'))
                    <a href="{{ route('jobs.index') }}" style="padding: 0.65rem 1rem; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 12px; font-weight: 700; font-size: 0.88rem; text-decoration: none;">
                        Clear
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Jobs Grid / List --}}
@if($jobs->isEmpty())
    <div class="glass-card" style="padding: 4rem; text-align: center;">
        <div style="width: 56px; height: 56px; background: #EEF2FF; border-radius: 16px; margin: 0 auto 1.2rem auto; display: flex; align-items: center; justify-content: center;">
            <svg width="28" height="28" fill="none" stroke="#4F46E5" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h3 style="font-size: 1.2rem; font-weight: 800; color: #0F172A; margin: 0 0 0.4rem 0;">No Job Listings Found</h3>
        <p style="color: #64748B; margin: 0;">Try searching for a different keyword or experience level.</p>
    </div>
@else
    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
        @foreach($jobs as $job)
        @php
            $expColor = match($job->experience_level) {
                'entry' => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                'senior' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                default => ['bg' => '#DBEAFE', 'text' => '#1D4ED8']
            };
        @endphp
        <div class="glass-card" style="padding: 1.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
            
            <!-- Job Info -->
            <div style="flex: 1; min-width: 280px;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: #0F172A; margin: 0;">{{ $job->title }}</h3>
                    <span style="padding: 3px 12px; background: {{ $expColor['bg'] }}; color: {{ $expColor['text'] }}; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                        {{ ucfirst($job->experience_level) }} Level
                    </span>
                    @if(auth()->user()->role !== 'candidate')
                        <span style="padding: 3px 12px; background: #EEF2FF; color: #4F46E5; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                            {{ $job->candidates->count() }} Applicants
                        </span>
                    @endif
                </div>
                <p style="color: #475569; font-size: 0.9rem; margin: 0 0 0.5rem 0; line-height: 1.5;">
                    <strong style="color: #0F172A;">Required Skills:</strong> {{ $job->required_skills }}
                </p>
                <p style="color: #94A3B8; font-size: 0.8rem; margin: 0; font-weight: 600;">
                    Posted {{ $job->created_at->diffForHumans() }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0;">
                <a href="{{ route('jobs.show', $job->id) }}" style="padding: 0.6rem 1.4rem; background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE; border-radius: 50px; font-weight: 800; font-size: 0.85rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#E0E7FF'" onmouseout="this.style.background='#EEF2FF'">
                    View Details
                </a>
                
                @if(auth()->user()->role === 'candidate')
                    <a href="{{ route('candidates.create', ['job_id' => $job->id]) }}" style="padding: 0.6rem 1.4rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; border-radius: 50px; font-weight: 800; font-size: 0.85rem; text-decoration: none; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                        Apply Now
                    </a>
                @else
                    <a href="{{ route('jobs.edit', $job->id) }}" style="padding: 0.6rem 1.2rem; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-decoration: none;">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" onsubmit="return confirm('Delete this job posting?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="padding: 0.6rem 1.2rem; background: #FEE2E2; color: #EF4444; border: 1px solid #FECACA; border-radius: 50px; font-weight: 800; font-size: 0.85rem; cursor: pointer;">
                            Delete
                        </button>
                    </form>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($jobs->hasPages())
        <div style="margin-top: 2rem;">
            {{ $jobs->links() }}
        </div>
    @endif
@endif

@endsection
