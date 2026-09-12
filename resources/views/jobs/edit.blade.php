@extends('layouts.app')
@section('title', 'Edit Job Posting')

@section('content')
<div class="page-header">
    <h1>Edit Job Posting</h1>
    <p>Update the details for this job opening.</p>
</div>

<div class="card" style="max-width:700px;">
    <form method="POST" action="{{ route('jobs.update', $job->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $job->title) }}">
            @error('title') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="experience_level">Experience Level</label>
            <select id="experience_level" name="experience_level" class="form-control">
                <option value="entry" {{ old('experience_level', $job->experience_level) === 'entry' ? 'selected' : '' }}>Entry Level</option>
                <option value="mid" {{ old('experience_level', $job->experience_level) === 'mid' ? 'selected' : '' }}>Mid Level</option>
                <option value="senior" {{ old('experience_level', $job->experience_level) === 'senior' ? 'selected' : '' }}>Senior Level</option>
            </select>
            @error('experience_level') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="required_skills">Required Skills</label>
            <input type="text" id="required_skills" name="required_skills" class="form-control" value="{{ old('required_skills', $job->required_skills) }}">
            @error('required_skills') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea id="description" name="description" class="form-control" rows="6">{{ old('description', $job->description) }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Update Job Posting</button>
            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
