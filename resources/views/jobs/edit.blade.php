@extends('layouts.app')
@section('title', 'Edit Job Posting')

@section('content')

<style>
    .form-card { background:white; border-radius:20px; border:1px solid #f0eaff; box-shadow:0 4px 20px rgba(124,58,237,0.07); padding:2.5rem; }
    .form-label { display:block; font-size:0.85rem; font-weight:700; color:#374151; margin-bottom:0.5rem; }
    .form-input { width:100%; padding:0.8rem 1rem; border-radius:10px; border:1.5px solid #e2e8f0; background:#faf5ff; font-size:0.9rem; outline:none; transition:border 0.2s,box-shadow 0.2s; box-sizing:border-box; font-family:'Outfit',sans-serif; color:#1e1b4b; }
    .form-input:focus { border-color:#7C3AED; box-shadow:0 0 0 3px rgba(124,58,237,0.1); background:white; }
    .form-hint { font-size:0.78rem; color:#94a3b8; margin:0.4rem 0 0; }
    .form-error { font-size:0.8rem; color:#dc2626; margin:0.4rem 0 0; }
</style>

<div style="max-width:760px;margin:0 auto;">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
        <a href="{{ route('jobs.show', $job->id) }}"
            style="width:40px;height:40px;border-radius:10px;background:white;border:1.5px solid #ede9fe;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;transition:background 0.2s;"
            onmouseover="this.style.background='#ede9fe'" onmouseout="this.style.background='white'">
            <svg width="18" height="18" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 style="font-size:1.75rem;font-weight:900;color:#1e1b4b;margin:0;letter-spacing:-0.02em;">Edit Job Posting</h1>
            <p style="color:#64748b;font-size:0.875rem;margin:0.2rem 0 0;">Update the details for this job opening.</p>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('jobs.update', $job->id) }}">
            @csrf @method('PUT')

            <div style="margin-bottom:1.5rem;">
                <label class="form-label" for="title">Job Title</label>
                <input class="form-input" type="text" id="title" name="title" value="{{ old('title', $job->title) }}" placeholder="e.g. Senior Software Engineer">
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label" for="experience_level">Experience Level</label>
                <select class="form-input" id="experience_level" name="experience_level" style="cursor:pointer;">
                    <option value="entry" {{ old('experience_level', $job->experience_level) === 'entry' ? 'selected' : '' }}>Entry Level</option>
                    <option value="mid" {{ old('experience_level', $job->experience_level) === 'mid' ? 'selected' : '' }}>Mid Level</option>
                    <option value="senior" {{ old('experience_level', $job->experience_level) === 'senior' ? 'selected' : '' }}>Senior Level</option>
                </select>
                @error('experience_level') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label" for="required_skills">Required Skills</label>
                <input class="form-input" type="text" id="required_skills" name="required_skills" value="{{ old('required_skills', $job->required_skills) }}" placeholder="e.g. PHP, Laravel, MySQL">
                <p class="form-hint">Separate skills with commas. Used by AI to calculate candidate match scores.</p>
                @error('required_skills') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label" for="description">Job Description</label>
                <textarea class="form-input" id="description" name="description" rows="8" style="resize:vertical;">{{ old('description', $job->description) }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="display:flex;align-items:center;gap:1rem;padding-top:1.5rem;border-top:1px solid #f0eaff;">
                <button type="submit"
                    style="padding:0.8rem 2rem;border-radius:12px;background:linear-gradient(135deg,#7C3AED,#C084FC);color:white;font-weight:800;font-size:0.95rem;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(124,58,237,0.3);font-family:'Outfit',sans-serif;">
                    Update Job Posting
                </button>
                <a href="{{ route('jobs.show', $job->id) }}"
                    style="padding:0.8rem 1.5rem;border-radius:12px;border:1.5px solid #e2e8f0;color:#64748b;font-weight:600;font-size:0.875rem;text-decoration:none;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
