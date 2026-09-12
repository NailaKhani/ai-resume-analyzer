@extends('layouts.app')
@section('title', 'Create Job Posting')

@section('content')
<div class="page-header">
    <h1>Create Job Posting</h1>
    <p>Fill in the details below to post a new job opening.</p>
</div>

<div class="card" style="max-width:700px;">
    <form method="POST" action="{{ route('jobs.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Senior Software Engineer">
            @error('title') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="experience_level">Experience Level</label>
            <select id="experience_level" name="experience_level" class="form-control">
                <option value="">Select level...</option>
                <option value="entry" {{ old('experience_level') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                <option value="mid" {{ old('experience_level') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                <option value="senior" {{ old('experience_level') === 'senior' ? 'selected' : '' }}>Senior Level</option>
            </select>
            @error('experience_level') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="required_skills">Required Skills</label>
            <input type="text" id="required_skills" name="required_skills" class="form-control" value="{{ old('required_skills') }}" placeholder="e.g. PHP, Laravel, MySQL, REST APIs">
            @error('required_skills') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea id="description" name="description" class="form-control" rows="6" placeholder="Describe the role, responsibilities, and requirements...">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Create Job Posting</button>
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
