@extends('layouts.app')
@section('title', 'My Applications')

@section('content')
<div class="page-header">
    <h1>My Applications</h1>
    <p>Track the status of all your submitted applications.</p>
</div>

<div class="card">
    @if($applications->isEmpty())
        <div class="empty-state">
            <h3>No applications yet</h3>
            <p>Browse open positions and submit your resume to get started.</p>
            <br>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
        </div>
    @else
    <table>
        <thead>
            <tr>
                <th>Position</th>
                <th>Experience Level</th>
                <th>Match Score</th>
                <th>Skills Detected</th>
                <th>Applied</th>
                <th>Resume</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
            <tr>
                <td><strong>{{ $app->jobPosting->title ?? '–' }}</strong></td>
                <td>
                    @if($app->jobPosting)
                        @php $cls = ['entry'=>'badge-green','mid'=>'badge-blue','senior'=>'badge-amber']; @endphp
                        <span class="badge {{ $cls[$app->jobPosting->experience_level] ?? 'badge-gray' }}">{{ ucfirst($app->jobPosting->experience_level) }}</span>
                    @endif
                </td>
                <td>
                    @if($app->match_score !== null)
                        <div style="display:flex;align-items:center;gap:0.6rem;">
                            <div class="score-bar-wrapper"><div class="score-bar" style="width:{{ min($app->match_score, 100) }}%"></div></div>
                            <span style="font-weight:700;font-size:0.875rem;">{{ number_format($app->match_score, 1) }}%</span>
                        </div>
                    @else
                        <span class="badge badge-amber">Analyzing...</span>
                    @endif
                </td>
                <td>
                    @if($app->parsed_skills)
                        @foreach(array_slice((array)$app->parsed_skills, 0, 4) as $skill)
                            <span class="badge badge-blue" style="margin:1px;">{{ $skill }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">Pending</span>
                    @endif
                </td>
                <td class="text-muted">{{ $app->created_at->diffForHumans() }}</td>
                <td>
                    @if($app->resume_path)
                        <a href="{{ Storage::url($app->resume_path) }}" target="_blank" class="btn btn-secondary btn-sm">Download</a>
                    @else
                        <span class="text-muted">–</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('candidates.destroy', $app->id) }}" onsubmit="return confirm('Withdraw this application?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Withdraw</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:1.25rem;">{{ $applications->links() }}</div>
    @endif
</div>
@endsection
