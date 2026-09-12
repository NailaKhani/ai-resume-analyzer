@extends('layouts.app')
@section('title', $job->title)

@section('content')
<div class="page-header">
    <div class="flex justify-between items-center">
        <div>
            <h1>{{ $job->title }}</h1>
            <p>Posted {{ $job->created_at->diffForHumans() }} by {{ $job->user->name }}</p>
        </div>
        <div class="btn-group">
            @if(auth()->user()->role !== 'candidate')
                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary">Edit</a>
            @endif
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<div class="grid-2" style="gap:1.5rem; align-items:start;">

    {{-- Left: Job Details --}}
    <div>
        <div class="card" style="margin-bottom:1.25rem;">
            <div class="card-title">Job Details</div>
            <table style="width:100%;">
                <tr>
                    <td style="padding:0.5rem 0;color:#64748b;font-size:0.875rem;font-weight:500;width:140px;">Experience Level</td>
                    <td>
                        @php $cls = ['entry'=>'badge-green','mid'=>'badge-blue','senior'=>'badge-amber']; @endphp
                        <span class="badge {{ $cls[$job->experience_level] ?? 'badge-gray' }}">{{ ucfirst($job->experience_level) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0;color:#64748b;font-size:0.875rem;font-weight:500;">Required Skills</td>
                    <td style="font-size:0.9rem;">{{ $job->required_skills }}</td>
                </tr>
            </table>
        </div>

        <div class="card">
            <div class="card-title">Job Description</div>
            <p style="font-size:0.9rem;line-height:1.7;color:#374151;white-space:pre-wrap;">{{ $job->description }}</p>
        </div>
    </div>

    {{-- Right: Apply or Candidates List --}}
    <div>
        @if(auth()->user()->role === 'candidate')
            <div class="card">
                <div class="card-title">Apply for this Position</div>
                @if($alreadyApplied)
                    <div class="alert alert-success" style="margin-bottom:0;">
                        You have already applied for this position. We will analyze your resume and update your match score.
                    </div>
                @else
                    <p style="font-size:0.9rem;color:#64748b;margin-bottom:1.25rem;">Upload your resume to apply. Our AI system will automatically analyze it and calculate your match score for this position.</p>
                    <form method="POST" action="{{ route('candidates.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_posting_id" value="{{ $job->id }}">
                        <div class="form-group">
                            <label for="resume">Resume File (PDF or DOCX)</label>
                            <input type="file" id="resume" name="resume" class="form-control" accept=".pdf,.docx">
                            @error('resume') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;">Submit Application</button>
                    </form>
                @endif
            </div>
        @else
            {{-- HR/Admin see the candidates for this job --}}
            <div class="card">
                <div class="flex justify-between items-center mb-2">
                    <div class="card-title" style="margin-bottom:0;">Applicants ({{ $job->candidates->count() }})</div>
                </div>
                @if($job->candidates->isEmpty())
                    <div class="empty-state" style="padding:1.5rem;">
                        <h3>No applicants yet</h3>
                        <p>Candidates will appear here once they apply.</p>
                    </div>
                @else
                    @foreach($job->candidates as $c)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 0;border-bottom:1px solid #f1f5f9;">
                        <div>
                            <div style="font-weight:600;font-size:0.9rem;">{{ $c->user->name }}</div>
                            <div class="text-muted">{{ $c->user->email }}</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            @if($c->match_score !== null)
                                <strong style="font-size:0.9rem;">{{ number_format($c->match_score, 1) }}%</strong>
                            @else
                                <span class="badge badge-gray">Analyzing...</span>
                            @endif
                            <a href="{{ route('candidates.show', $c->id) }}" class="btn btn-secondary btn-sm">Review</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
