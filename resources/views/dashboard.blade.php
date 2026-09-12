@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p>
        @if(auth()->user()->role === 'admin')
            System overview — manage all jobs, candidates, and users.
        @elseif(auth()->user()->role === 'hr')
            Manage your job postings and review candidate applications below.
        @else
            Browse open positions and track your applications below.
        @endif
    </p>
</div>

<div class="stats-grid">
    @if(auth()->user()->role !== 'candidate')
        <div class="stat-card blue">
            <div class="stat-number">{{ $totalJobs }}</div>
            <div class="stat-label">Active Job Postings</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number">{{ $totalCandidates }}</div>
            <div class="stat-label">Total Applications</div>
        </div>
        <div class="stat-card amber">
            <div class="stat-number">{{ $avgScore }}%</div>
            <div class="stat-label">Average Match Score</div>
        </div>
    @else
        <div class="stat-card blue">
            <div class="stat-number">{{ $totalJobs }}</div>
            <div class="stat-label">Open Positions</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number">{{ $myApplications }}</div>
            <div class="stat-label">My Applications</div>
        </div>
        <div class="stat-card amber">
            <div class="stat-number">{{ $bestScore }}%</div>
            <div class="stat-label">My Best Match Score</div>
        </div>
    @endif
</div>

{{-- HR / Admin: Recent Applications --}}
@if(auth()->user()->role !== 'candidate')
<div class="card">
    <div class="flex justify-between items-center mb-2">
        <div class="card-title" style="margin-bottom:0">Recent Applications</div>
        <a href="{{ route('candidates.index') }}" class="btn btn-secondary btn-sm">View All</a>
    </div>
    @if($recentCandidates->isEmpty())
        <div class="empty-state"><h3>No applications yet</h3><p>Candidates will appear here once they apply.</p></div>
    @else
    <table>
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Applied For</th>
                <th>Match Score</th>
                <th>Applied</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentCandidates as $c)
            <tr>
                <td><strong>{{ $c->user->name }}</strong><br><span class="text-muted">{{ $c->user->email }}</span></td>
                <td>{{ $c->jobPosting->title ?? '–' }}</td>
                <td>
                    @if($c->match_score !== null)
                        <div style="display:flex;align-items:center;gap:0.6rem;">
                            <div class="score-bar-wrapper"><div class="score-bar" style="width:{{ $c->match_score }}%"></div></div>
                            <span style="font-weight:600;font-size:0.85rem;">{{ number_format($c->match_score, 1) }}%</span>
                        </div>
                    @else
                        <span class="badge badge-gray">Pending</span>
                    @endif
                </td>
                <td class="text-muted">{{ $c->created_at->diffForHumans() }}</td>
                <td><a href="{{ route('candidates.show', $c->id) }}" class="btn btn-secondary btn-sm">Review</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@else
{{-- Candidate: Browse Jobs --}}
<div class="card">
    <div class="flex justify-between items-center mb-2">
        <div class="card-title" style="margin-bottom:0">Open Positions</div>
        <a href="{{ route('jobs.index') }}" class="btn btn-secondary btn-sm">Browse All</a>
    </div>
    @if($latestJobs->isEmpty())
        <div class="empty-state"><h3>No open positions right now</h3><p>Check back soon.</p></div>
    @else
    <table>
        <thead>
            <tr><th>Job Title</th><th>Experience</th><th>Posted</th><th>Action</th></tr>
        </thead>
        <tbody>
            @foreach($latestJobs as $job)
            <tr>
                <td><strong>{{ $job->title }}</strong></td>
                <td><span class="badge badge-blue">{{ ucfirst($job->experience_level) }}</span></td>
                <td class="text-muted">{{ $job->created_at->diffForHumans() }}</td>
                <td><a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View & Apply</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endif
@endsection
