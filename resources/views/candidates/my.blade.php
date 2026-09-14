@extends('layouts.app')
@section('title', 'My Applications')

@section('content')

{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0 0 0.4rem 0;">My Job Applications</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Track AI match scores and status updates for your applications.</p>
    </div>
    <a href="{{ route('jobs.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.6rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 800; font-size: 0.88rem; text-decoration: none; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);">
        Browse Open Jobs
    </a>
</div>

@if($applications->isEmpty())
    <div class="glass-card" style="padding: 4rem 2rem; text-align: center; max-width: 540px; margin: 0 auto;">
        <div style="width: 64px; height: 64px; background: #EEF2FF; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem auto;">
            <svg width="32" height="32" fill="none" stroke="#4F46E5" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h3 style="font-size: 1.3rem; font-weight: 900; color: #0F172A; margin: 0 0 0.5rem 0;">No Applications Submitted Yet</h3>
        <p style="color: #64748B; margin: 0 0 1.75rem 0; font-size: 0.92rem; line-height: 1.6;">Browse our active job listings and submit your resume to get instant AI match feedback.</p>
        <a href="{{ route('jobs.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 2rem; border-radius: 50px; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; font-weight: 800; text-decoration: none; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);">
            Find Jobs Now →
        </a>
    </div>
@else
    <div class="glass-card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>AI Match Score</th>
                        <th>Status</th>
                        <th>Skills Detected</th>
                        <th>Applied Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr>
                        <!-- Position -->
                        <td>
                            <div>
                                <p style="margin: 0; font-weight: 800; color: #0F172A; font-size: 0.95rem;">
                                    {{ $app->jobPosting->title ?? 'General Listing' }}
                                </p>
                                <span style="font-size: 0.75rem; color: #64748B; font-weight: 600;">
                                    {{ ucfirst($app->jobPosting->experience_level ?? 'mid') }} Level
                                </span>
                            </div>
                        </td>

                        <!-- Match Score -->
                        <td>
                            @if($app->match_score !== null)
                                <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" x-data @click="$dispatch('open-modal-{{ $app->id }}')">
                                    <div style="width: 80px; height: 8px; background: #E2E8F0; border-radius: 10px; overflow: hidden;">
                                        <div style="width: {{ min($app->match_score, 100) }}%; height: 100%; background: linear-gradient(90deg, #3B82F6, #4F46E5); border-radius: 10px;"></div>
                                    </div>
                                    <span style="font-weight: 900; color: #4F46E5; font-size: 0.88rem; text-decoration: underline;">
                                        {{ number_format($app->match_score, 1) }}%
                                    </span>
                                </div>
                                <x-match-breakdown-modal :candidate="$app" />
                            @else
                                <span style="padding: 3px 10px; background: #F1F5F9; color: #64748B; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">Pending</span>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td>
                            @php
                                $statusStyle = match($app->status) {
                                    'Shortlisted' => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                                    'Interviewed' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                                    'Rejected'    => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
                                    'Screened'    => ['bg' => '#DBEAFE', 'text' => '#1D4ED8'],
                                    default       => ['bg' => '#EEF2FF', 'text' => '#4F46E5']
                                };
                            @endphp
                            <span style="padding: 4px 12px; background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['text'] }}; border-radius: 50px; font-size: 0.78rem; font-weight: 800;">
                                {{ $app->status }}
                            </span>
                        </td>

                        <!-- Skills Detected -->
                        <td>
                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                @if($app->parsed_skills)
                                    @foreach(array_slice((array)$app->parsed_skills, 0, 3) as $skill)
                                        <span style="padding: 2px 8px; background: #EEF2FF; color: #4F46E5; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid #C7D2FE;">{{ $skill }}</span>
                                    @endforeach
                                    @if(count((array)$app->parsed_skills) > 3)
                                        <span style="font-size: 0.75rem; color: #94A3B8; font-weight: 700;">+{{ count((array)$app->parsed_skills) - 3 }}</span>
                                    @endif
                                @else
                                    <span style="color: #94A3B8; font-size: 0.8rem;">–</span>
                                @endif
                            </div>
                        </td>

                        <!-- Applied Date -->
                        <td style="color: #64748B; font-size: 0.82rem; font-weight: 600;">
                            {{ $app->created_at->diffForHumans() }}
                        </td>

                        <!-- Actions -->
                        <td>
                            @if($app->jobPosting)
                                <a href="{{ route('jobs.show', $app->jobPosting->id) }}" style="padding: 5px 14px; background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE; border-radius: 50px; font-size: 0.78rem; font-weight: 800; text-decoration: none;">
                                    View Job
                                </a>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
