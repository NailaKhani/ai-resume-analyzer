@extends('layouts.app')
@section('title', $candidate->user->name . ' – Application')

@section('content')
<div class="page-header">
    <div class="flex justify-between items-center">
        <div>
            <h1>{{ $candidate->user->name }}</h1>
            <p>Application for: <strong>{{ $candidate->jobPosting->title ?? '–' }}</strong></p>
        </div>
        <a href="{{ route('candidates.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="grid-2" style="gap:1.5rem;align-items:start;">
    {{-- Left: Match Score & Info --}}
    <div>
        <div class="card" style="margin-bottom:1.25rem;text-align:center;">
            <div class="card-title">AI Match Score</div>
            @if($candidate->match_score !== null)
                @php
                    $score = $candidate->match_score;
                    $color = $score >= 75 ? '#059669' : ($score >= 50 ? '#d97706' : '#dc2626');
                @endphp
                <div style="font-size:3.5rem;font-weight:800;color:{{ $color }};line-height:1.1;">{{ number_format($score, 1) }}%</div>
                <div style="color:#64748b;font-size:0.875rem;margin-top:0.5rem;">
                    @if($score >= 75) Strong match for this position
                    @elseif($score >= 50) Moderate match — review skills gap
                    @else Low match — may not meet requirements
                    @endif
                </div>
                <div class="score-bar-wrapper" style="margin:1rem auto 0;max-width:220px;">
                    <div class="score-bar" style="width:{{ $score }}%;background:{{ $color }};"></div>
                </div>
            @else
                <div style="font-size:1.25rem;color:#94a3b8;padding:1rem 0;">
                    Resume is being analyzed...
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-title">Candidate Info</div>
            <table style="width:100%;">
                <tr>
                    <td style="padding:0.5rem 0;color:#64748b;font-size:0.875rem;width:110px;">Name</td>
                    <td style="font-size:0.9rem;">{{ $candidate->user->name }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0;color:#64748b;font-size:0.875rem;">Email</td>
                    <td style="font-size:0.9rem;">{{ $candidate->user->email }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0;color:#64748b;font-size:0.875rem;">Applied For</td>
                    <td style="font-size:0.9rem;">{{ $candidate->jobPosting->title ?? '–' }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0;color:#64748b;font-size:0.875rem;">Applied On</td>
                    <td style="font-size:0.9rem;">{{ $candidate->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            @if($candidate->resume_path)
                <div style="margin-top:1.25rem;">
                    <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank" class="btn btn-primary" style="width:100%;justify-content:center;">
                        Download Resume
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Right: Skill Analysis --}}
    <div>
        <div class="card" style="margin-bottom:1.25rem;">
            <div class="card-title">Extracted Skills from Resume</div>
            @if($candidate->parsed_skills && count((array)$candidate->parsed_skills) > 0)
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                    @foreach((array)$candidate->parsed_skills as $skill)
                        <span class="badge badge-blue" style="font-size:0.85rem;padding:0.35rem 0.85rem;">{{ $skill }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No skills extracted yet. Analysis may still be in progress.</p>
            @endif
        </div>

        <div class="card">
            <div class="card-title">Required Skills for This Job</div>
            @if($candidate->jobPosting)
                @php $required = explode(',', $candidate->jobPosting->required_skills); @endphp
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
                    @foreach($required as $skill)
                        @php $s = trim($skill); @endphp
                        @php
                            $extracted = array_map('strtolower', (array)($candidate->parsed_skills ?? []));
                            $matched = in_array(strtolower($s), $extracted);
                        @endphp
                        <span class="badge {{ $matched ? 'badge-green' : 'badge-gray' }}" style="font-size:0.85rem;padding:0.35rem 0.85rem;">
                            {{ $s }}
                        </span>
                    @endforeach
                </div>
                <p class="text-muted" style="font-size:0.8rem;">Green = matched in resume &nbsp;|&nbsp; Gray = missing</p>
            @endif
        </div>
    </div>
</div>
@endsection
