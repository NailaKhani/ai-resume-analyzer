@extends('layouts.app')
@section('title', 'Edit Job Posting')

@section('content')

<div style="max-width: 760px; margin: 0 auto;">

    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('jobs.show', $job->id) }}" style="width: 42px; height: 42px; border-radius: 12px; background: white; border: 1.5px solid #E2E8F0; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='white'">
            <svg width="20" height="20" fill="none" stroke="#4F46E5" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 900; color: #0F172A; margin: 0;">Edit Job Posting</h1>
            <p style="color: #64748B; font-size: 0.9rem; margin: 0.2rem 0 0 0;">Update the details for this job opening.</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 2.5rem;">
        <form method="POST" action="{{ route('jobs.update', $job->id) }}">
            @csrf @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 6px;" for="title">Job Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" placeholder="e.g. Senior Backend Laravel Developer">
                @error('title') <p style="color: #EF4444; font-size: 0.8rem; margin: 4px 0 0 0; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 6px;" for="experience_level">Experience Level</label>
                <select id="experience_level" name="experience_level">
                    <option value="entry" {{ old('experience_level', $job->experience_level) === 'entry' ? 'selected' : '' }}>Entry Level</option>
                    <option value="mid" {{ old('experience_level', $job->experience_level) === 'mid' ? 'selected' : '' }}>Mid Level</option>
                    <option value="senior" {{ old('experience_level', $job->experience_level) === 'senior' ? 'selected' : '' }}>Senior Level</option>
                </select>
                @error('experience_level') <p style="color: #EF4444; font-size: 0.8rem; margin: 4px 0 0 0; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 6px;" for="required_skills">Required Skills</label>
                <input type="text" id="required_skills" name="required_skills" value="{{ old('required_skills', $job->required_skills) }}" placeholder="e.g. PHP, Laravel, MySQL, REST APIs">
                <p style="font-size: 0.78rem; color: #64748B; margin: 4px 0 0 0; font-weight: 600;">Separate skills with commas. Used by AI to calculate candidate match scores.</p>
                @error('required_skills') <p style="color: #EF4444; font-size: 0.8rem; margin: 4px 0 0 0; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 6px;" for="description">Job Description</label>
                <textarea id="description" name="description" rows="8">{{ old('description', $job->description) }}</textarea>
                @error('description') <p style="color: #EF4444; font-size: 0.8rem; margin: 4px 0 0 0; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('jobs.show', $job->id) }}" style="padding: 0.75rem 1.6rem; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 50px; font-weight: 700; font-size: 0.9rem; text-decoration: none;">Cancel</a>
                <button type="submit" style="padding: 0.75rem 2.2rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; border: none; border-radius: 50px; font-weight: 800; font-size: 0.92rem; cursor: pointer; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
