@extends('layouts.app')
@section('title', 'Candidate Applications')

@section('content')

{{-- Header Row --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0 0 0.4rem 0;">Candidate Applications</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Ranked dynamically by AI match score & NLP skill extraction.</p>
    </div>
    <a href="{{ route('candidates.export', request()->all()) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.4rem; background: #0F172A; color: white; border-radius: 50px; font-weight: 700; font-size: 0.88rem; text-decoration: none; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15); transition: all 0.2s;" onmouseover="this.style.background='#1E293B'" onmouseout="this.style.background='#0F172A'">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Export CSV
    </a>
</div>

{{-- Filter Panel --}}
<div class="glass-card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('candidates.index') }}">
        <div style="display: grid; grid-template-columns: 2fr 1.5fr 1.5fr 1.2fr auto; gap: 1.2rem; align-items: end;">
            
            <!-- Search -->
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Search Candidate</label>
                <input type="text" name="search" placeholder="Name or email..." value="{{ request('search') }}">
            </div>

            <!-- Job Filter -->
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Filter by Job</label>
                <select name="job">
                    <option value="">All Jobs</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ request('job') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Min Score Range -->
            <div x-data="{ score: {{ request('min_score', 0) }} }}">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <label style="font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Min Match Score</label>
                    <span x-text="score + '%'" style="font-size: 0.8rem; font-weight: 800; color: #4F46E5;"></span>
                </div>
                <input type="range" name="min_score" min="0" max="100" step="5" x-model="score" style="width: 100%; height: 6px; accent-color: #4F46E5; cursor: pointer;">
            </div>

            <!-- Status Filter -->
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Status</label>
                <select name="status">
                    <option value="">All Statuses</option>
                    @foreach(['Pending','Screened','Shortlisted','Interviewed','Rejected'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Buttons -->
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="padding: 0.65rem 1.4rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; border: none; border-radius: 12px; font-weight: 800; font-size: 0.88rem; cursor: pointer;">
                    Filter
                </button>
                @if(request('search') || request('job') || request('status') || request('min_score'))
                    <a href="{{ route('candidates.index') }}" style="padding: 0.65rem 1rem; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 12px; font-weight: 700; font-size: 0.88rem; text-decoration: none;">
                        Clear
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>

{{-- Candidates List Table --}}
@if($candidates->isEmpty())
    <div class="glass-card" style="padding: 4rem; text-align: center;">
        <div style="width: 56px; height: 56px; background: #EEF2FF; border-radius: 16px; margin: 0 auto 1.2rem auto; display: flex; align-items: center; justify-content: center;">
            <svg width="28" height="28" fill="none" stroke="#4F46E5" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3 style="font-size: 1.2rem; font-weight: 800; color: #0F172A; margin: 0 0 0.4rem 0;">No Candidate Applications Found</h3>
        <p style="color: #64748B; margin: 0;">Try adjusting your filters or search terms.</p>
    </div>
@else
    <div class="glass-card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Applied For</th>
                        <th>AI Match Score</th>
                        <th>Status</th>
                        <th>Matched Skills</th>
                        <th>Applied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $c)
                    <tr>
                        <!-- Candidate Info -->
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #3B82F6, #4F46E5); color: white; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    {{ strtoupper(substr($c->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 800; color: #0F172A; font-size: 0.92rem;">{{ $c->user->name }}</p>
                                    <p style="margin: 0; color: #64748B; font-size: 0.78rem;">{{ $c->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Job Title -->
                        <td style="font-weight: 700; color: #334155;">
                            {{ $c->jobPosting->title ?? 'General Listing' }}
                        </td>

                        <!-- AI Score + Breakdown Modal Trigger -->
                        <td>
                            @if($c->match_score !== null)
                                <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" x-data @click="$dispatch('open-modal-{{ $c->id }}')">
                                    <div style="width: 90px; height: 8px; background: #E2E8F0; border-radius: 10px; overflow: hidden;">
                                        <div style="width: {{ min($c->match_score, 100) }}%; height: 100%; background: linear-gradient(90deg, #3B82F6, #4F46E5); border-radius: 10px;"></div>
                                    </div>
                                    <span style="font-weight: 900; color: #4F46E5; font-size: 0.88rem; text-decoration: underline;">
                                        {{ number_format($c->match_score, 1) }}%
                                    </span>
                                </div>
                                <x-match-breakdown-modal :candidate="$c" />
                            @else
                                <span style="padding: 3px 10px; background: #F1F5F9; color: #64748B; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">Pending AI</span>
                            @endif
                        </td>

                        <!-- Status Selector -->
                        <td>
                            <form method="POST" action="{{ route('candidates.status', $c->id) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" style="padding: 4px 10px; font-size: 0.78rem; font-weight: 800; border-radius: 50px; background: #F8FAFC; border: 1.5px solid #CBD5E1; cursor: pointer;">
                                    @foreach(['Pending','Screened','Shortlisted','Interviewed','Rejected'] as $st)
                                        <option value="{{ $st }}" {{ $c->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>

                        <!-- Skills Badges -->
                        <td>
                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                @if($c->parsed_skills)
                                    @foreach(array_slice((array)$c->parsed_skills, 0, 3) as $skill)
                                        <span style="padding: 2px 8px; background: #EEF2FF; color: #4F46E5; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid #C7D2FE;">{{ $skill }}</span>
                                    @endforeach
                                    @if(count((array)$c->parsed_skills) > 3)
                                        <span style="font-size: 0.75rem; color: #94A3B8; font-weight: 700; align-self: center;">+{{ count((array)$c->parsed_skills) - 3 }}</span>
                                    @endif
                                @else
                                    <span style="color: #94A3B8; font-size: 0.8rem;">–</span>
                                @endif
                            </div>
                        </td>

                        <!-- Applied Date -->
                        <td style="color: #64748B; font-size: 0.82rem; font-weight: 600;">
                            {{ $c->created_at->diffForHumans() }}
                        </td>

                        <!-- Action Buttons -->
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <a href="{{ route('candidates.show', $c->id) }}" style="padding: 5px 12px; background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE; border-radius: 8px; font-size: 0.78rem; font-weight: 800; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#E0E7FF'" onmouseout="this.style.background='#EEF2FF'">
                                    Review
                                </a>
                                <form method="POST" action="{{ route('candidates.destroy', $c->id) }}" onsubmit="return confirm('Remove this candidate application?')">
                                    @csrf @method('DELETE')
                                    <button style="padding: 5px 12px; background: #FEE2E2; color: #EF4444; border: 1px solid #FECACA; border-radius: 8px; font-size: 0.78rem; font-weight: 800; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#FCA5A5'" onmouseout="this.style.background='#FEE2E2'">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($candidates->hasPages())
            <div style="padding: 1.25rem 1.5rem; border-top: 1px solid #E2E8F0; background: #FAFAFA;">
                {{ $candidates->links() }}
            </div>
        @endif
    </div>
@endif

@endsection
