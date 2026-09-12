@extends('layouts.app')
@section('title', 'Job Postings')

@section('content')
<div class="page-header">
    <div class="flex justify-between items-center">
        <div>
            <h1>Job Postings</h1>
            <p>Browse all open positions or post a new one.</p>
        </div>
        @if(auth()->user()->role !== 'candidate')
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">+ Post New Job</a>
        @endif
    </div>
</div>

{{-- Search/Filter --}}
<div class="card" style="margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('jobs.index') }}">
        <div class="grid-2" style="align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Search Jobs</label>
                <input type="text" name="search" class="form-control" placeholder="Title, skills, keyword..." value="{{ request('search') }}">
            </div>
            <div class="flex gap-2" style="align-items:flex-end;">
                <div class="form-group" style="margin-bottom:0;flex:1;">
                    <label>Experience Level</label>
                    <select name="experience" class="form-control">
                        <option value="">All Levels</option>
                        <option value="entry" {{ request('experience') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="mid" {{ request('experience') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                        <option value="senior" {{ request('experience') === 'senior' ? 'selected' : '' }}>Senior Level</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search') || request('experience'))
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="card">
    @if($jobs->isEmpty())
        <div class="empty-state">
            <h3>No job postings found</h3>
            <p>Try adjusting your search or post a new job.</p>
        </div>
    @else
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Experience</th>
                <th>Required Skills</th>
                @if(auth()->user()->role !== 'candidate')
                    <th>Applications</th>
                @endif
                <th>Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td class="text-muted">{{ $job->id }}</td>
                <td><strong>{{ $job->title }}</strong></td>
                <td>
                    @php
                        $badgeClass = ['entry' => 'badge-green', 'mid' => 'badge-blue', 'senior' => 'badge-amber'];
                    @endphp
                    <span class="badge {{ $badgeClass[$job->experience_level] ?? 'badge-gray' }}">
                        {{ ucfirst($job->experience_level) }}
                    </span>
                </td>
                <td style="max-width:220px;">
                    <span class="text-muted" style="white-space:nowrap;overflow:hidden;display:block;text-overflow:ellipsis;">
                        {{ $job->required_skills }}
                    </span>
                </td>
                @if(auth()->user()->role !== 'candidate')
                    <td><span class="badge badge-gray">{{ $job->candidates->count() }}</span></td>
                @endif
                <td class="text-muted">{{ $job->created_at->diffForHumans() }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-secondary btn-sm">View</a>
                        @if(auth()->user()->role !== 'candidate')
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" onsubmit="return confirm('Delete this job posting?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:1.25rem;">{{ $jobs->links() }}</div>
    @endif
</div>
@endsection
