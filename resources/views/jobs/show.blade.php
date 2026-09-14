@extends('layouts.app')
@section('title', $job->title)

@section('content')

{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.4rem;">
            @php 
                $expColors = [
                    'entry' => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                    'senior' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                    'mid' => ['bg' => '#DBEAFE', 'text' => '#1D4ED8']
                ];
                $color = $expColors[$job->experience_level] ?? ['bg' => '#F1F5F9', 'text' => '#475569'];
            @endphp
            <span style="padding: 3px 12px; background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border-radius: 50px; font-size: 0.75rem; font-weight: 800;">
                {{ ucfirst($job->experience_level) }} Level
            </span>
            <span style="color: #64748B; font-size: 0.82rem; font-weight: 600;">Posted {{ $job->created_at->diffForHumans() }} by {{ $job->user->name }}</span>
        </div>
        <h1 style="font-size: 2.2rem; font-weight: 900; color: #0F172A; margin: 0;">{{ $job->title }}</h1>
    </div>

    <div style="display: flex; align-items: center; gap: 0.75rem;">
        @if(auth()->user()->role !== 'candidate')
            <a href="{{ route('jobs.edit', $job->id) }}" style="padding: 0.65rem 1.4rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; border-radius: 50px; font-weight: 800; font-size: 0.88rem; text-decoration: none;">Edit Job</a>
        @endif
        <a href="{{ route('jobs.index') }}" style="padding: 0.65rem 1.4rem; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 50px; font-weight: 700; font-size: 0.88rem; text-decoration: none;">Back to Jobs</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    
    {{-- Left: Job Details & Description --}}
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Job Details Card -->
        <div class="glass-card" style="padding: 2rem;">
            <h2 style="font-size: 1.2rem; font-weight: 800; color: #0F172A; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 1px solid #E2E8F0;">Required Qualifications</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <span style="width: 140px; font-size: 0.88rem; font-weight: 700; color: #64748B;">Experience Level</span>
                    <span style="padding: 3px 12px; background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border-radius: 50px; font-size: 0.78rem; font-weight: 800;">
                        {{ ucfirst($job->experience_level) }}
                    </span>
                </div>
                <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                    <span style="width: 140px; font-size: 0.88rem; font-weight: 700; color: #64748B;">Required Skills</span>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        @foreach(explode(',', $job->required_skills) as $skill)
                            <span style="padding: 4px 10px; background: #EEF2FF; color: #4F46E5; border-radius: 8px; font-size: 0.82rem; font-weight: 700; border: 1px solid #C7D2FE;">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card -->
        <div class="glass-card" style="padding: 2rem;">
            <h2 style="font-size: 1.2rem; font-weight: 800; color: #0F172A; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 1px solid #E2E8F0;">Full Job Description</h2>
            <p style="color: #334155; line-height: 1.75; font-size: 0.95rem; margin: 0; white-space: pre-wrap;">{{ $job->description }}</p>
        </div>

    </div>

    {{-- Right Column: Apply Widget / Applicants Count --}}
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @if(auth()->user()->role === 'candidate')
        <div class="glass-card" style="padding: 2rem;">
            <h2 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 1px solid #E2E8F0;">Application Status</h2>
            
            @if($alreadyApplied)
                <div style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 16px; padding: 1.5rem; text-align: center;">
                    <div style="width: 44px; height: 44px; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem auto;">
                        <svg width="24" height="24" fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #065F46; margin: 0 0 0.25rem 0;">Application Submitted</h3>
                    <p style="font-size: 0.85rem; color: #047857; margin: 0 0 1rem 0;">Your resume has been analyzed by AI.</p>
                    <a href="{{ route('candidates.my') }}" style="display: inline-block; padding: 0.6rem 1.2rem; background: #059669; color: white; border-radius: 50px; font-weight: 800; font-size: 0.82rem; text-decoration: none;">View My Application</a>
                </div>
            @else
                <p style="color: #64748B; font-size: 0.9rem; margin: 0 0 1.25rem 0; line-height: 1.6;">
                    Upload your resume (PDF/DOCX) to get instantly matched against this job listing using AI NLP.
                </p>

                {{-- Inline Apply Form --}}
                <form method="POST" action="{{ route('candidates.store') }}" enctype="multipart/form-data" id="applyForm-{{ $job->id }}">
                    @csrf
                    <input type="hidden" name="job_posting_id" value="{{ $job->id }}">

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 800; color: #334155; margin-bottom: 0.5rem; letter-spacing: -0.01em;">
                            Resume File <span style="color:#EF4444;">*</span>
                        </label>
                        <label for="resume_file_{{ $job->id }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; border: 2px dashed #CBD5E1; border-radius: 14px; cursor: pointer; transition: all 0.2s; background: #F8FAFC;" onmouseover="this.style.borderColor='#4F46E5';this.style.background='#EEF2FF'" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC'">
                            <svg width="20" height="20" fill="none" stroke="#4F46E5" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span id="fileLabel_{{ $job->id }}" style="font-size: 0.85rem; color: #64748B; font-weight: 600;">Click to upload PDF or DOCX</span>
                        </label>
                        <input id="resume_file_{{ $job->id }}" type="file" name="resume" accept=".pdf,.docx" required style="display:none;" onchange="document.getElementById('fileLabel_{{ $job->id }}').textContent = this.files[0] ? this.files[0].name : 'Click to upload PDF or DOCX'">
                        @error('resume') <p style="color:#EF4444;font-size:0.8rem;margin-top:0.3rem;">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" style="display:block; width:100%; padding:0.88rem 1.5rem; background:linear-gradient(135deg, #4F46E5, #7C3AED); color:white; border:none; border-radius:50px; font-weight:800; font-size:0.95rem; cursor:pointer; box-shadow:0 6px 18px rgba(79,70,229,0.35); font-family:'Outfit',sans-serif; transition:transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 24px rgba(79,70,229,0.45)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 18px rgba(79,70,229,0.35)'">
                        Apply For Job Now
                    </button>
                </form>
            @endif
        </div>
        @else
        <!-- HR / Admin View Applications Widget -->
        <div class="glass-card" style="padding: 2rem;">
            <h2 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0 0 1rem 0;">Applicants Overview</h2>
            <div style="padding: 1.25rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; text-align: center; margin-bottom: 1.25rem;">
                <span style="font-size: 2.2rem; font-weight: 900; color: #4F46E5; display: block; line-height: 1;">{{ $job->candidates->count() }}</span>
                <span style="font-size: 0.82rem; font-weight: 700; color: #64748B; uppercase;">Total Applications Received</span>
            </div>
            <a href="{{ route('candidates.index', ['job' => $job->id]) }}" style="display: block; text-align: center; width: 100%; padding: 0.75rem 1.5rem; background: #0F172A; color: white; border-radius: 50px; font-weight: 800; font-size: 0.88rem; text-decoration: none;">
                Review Applicants Pool
            </a>
        </div>
        @endif
    </div>

</div>

@endsection
