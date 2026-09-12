@extends('layouts.app')
@section('title', 'All Candidates')

@section('content')
<div class="page-header">
    <h1>Candidate Applications</h1>
    <p>All applications ranked by AI match score.</p>
</div>

{{-- Filter --}}
<div class="card" style="margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('candidates.index') }}">
        <div class="grid-2" style="align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Search by Name or Email</label>
                <input type="text" name="search" class="form-control" placeholder="Candidate name or email..." value="{{ request('search') }}">
            </div>
            <div class="flex gap-2" style="align-items:flex-end;">
                <div class="form-group" style="margin-bottom:0;flex:1;">
                    <label>Filter by Job</label>
                    <select name="job" class="form-control">
                        <option value="">All Jobs</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}" {{ request('job') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                @if(request('search') || request('job'))
                    <a href="{{ route('candidates.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </div>
    </form>
</div>

<div class="card">
    @if($candidates->isEmpty())
        <div class="empty-state">
            <h3>No candidates found</h3>
            <p>No applications match your search criteria.</p>
        </div>
    @else
    <table>
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Applied For</th>
                <th>Match Score</th>
                <th>Parsed Skills</th>
                <th>Applied</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidates as $c)
            <tr>
                <td>
                    <strong>{{ $c->user->name }}</strong><br>
                    <span class="text-muted">{{ $c->user->email }}</span>
                </td>
                <td>{{ $c->jobPosting->title ?? '–' }}</td>
                <td>
                    @if($c->match_score !== null)
                        <div style="display:flex;align-items:center;gap:0.6rem;">
                            <div class="score-bar-wrapper"><div class="score-bar" style="width:{{ min($c->match_score, 100) }}%"></div></div>
                            <span style="font-weight:700;font-size:0.875rem;min-width:38px;">{{ number_format($c->match_score, 1) }}%</span>
                        </div>
                    @else
                        <span class="badge badge-gray">Pending</span>
                    @endif
                </td>
                <td>
                    @if($c->parsed_skills)
                        @foreach(array_slice((array)$c->parsed_skills, 0, 3) as $skill)
                            <span class="badge badge-blue" style="margin:1px;">{{ $skill }}</span>
                        @endforeach
                        @if(count((array)$c->parsed_skills) > 3)
                            <span class="text-muted">+{{ count((array)$c->parsed_skills) - 3 }} more</span>
                        @endif
                    @else
                        <span class="text-muted">–</span>
                    @endif
                </td>
                <td class="text-muted">{{ $c->created_at->diffForHumans() }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('candidates.show', $c->id) }}" class="btn btn-secondary btn-sm">Review</a>
                        <form method="POST" action="{{ route('candidates.destroy', $c->id) }}" onsubmit="return confirm('Remove this application?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:1.25rem;">{{ $candidates->links() }}</div>
    @endif
</div>
@endsection
