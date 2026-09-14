@extends('layouts.app')
@section('title', $candidate->user->name . ' – Application')

@section('content')

{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('candidates.index') }}" style="width: 42px; height: 42px; border-radius: 12px; background: white; border: 1.5px solid #E2E8F0; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='white'">
            <svg width="20" height="20" fill="none" stroke="#4F46E5" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: #0F172A; margin: 0 0 0.2rem 0;">{{ $candidate->user->name }}</h1>
            <p style="color: #64748B; font-size: 0.9rem; margin: 0;">Applied for: <strong style="color: #0F172A;">{{ $candidate->jobPosting->title ?? 'General Listing' }}</strong></p>
        </div>
    </div>
    <div>
        <a href="{{ route('candidates.index') }}" style="padding: 0.65rem 1.4rem; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 50px; font-weight: 700; font-size: 0.88rem; text-decoration: none;">Back to Applications Pool</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
    
    {{-- Left Column: Score Card & Candidate Info --}}
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- AI Score Card -->
        <div class="glass-card" style="padding: 2rem; text-align: center;">
            <span style="font-size: 0.78rem; font-weight: 800; color: #4F46E5; text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-bottom: 1rem;">AI Match Score</span>
            @if($candidate->match_score !== null)
                @php
                    $score = $candidate->match_score;
                    $scoreColor = $score >= 70 ? '#10B981' : ($score >= 45 ? '#F59E0B' : '#EF4444');
                @endphp
                <div style="font-size: 4rem; font-weight: 900; color: {{ $scoreColor }}; line-height: 1; margin-bottom: 0.5rem;">
                    {{ number_format($score, 1) }}%
                </div>
                <div style="width: 100%; height: 10px; background: #E2E8F0; border-radius: 10px; overflow: hidden; margin: 1rem 0;">
                    <div style="width: {{ min($score, 100) }}%; height: 100%; background: {{ $scoreColor }}; border-radius: 10px;"></div>
                </div>
            @else
                <p style="color: #94A3B8; font-size: 0.9rem;">Analysis Pending</p>
            @endif
        </div>

        <!-- Candidate Info Card -->
        <div class="glass-card" style="padding: 2rem;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #0F172A; margin: 0 0 1.25rem 0; padding-bottom: 0.5rem; border-bottom: 1px solid #E2E8F0;">Candidate Details</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.9rem;">
                <div>
                    <span style="font-size: 0.75rem; color: #64748B; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Full Name</span>
                    <strong style="color: #0F172A;">{{ $candidate->user->name }}</strong>
                </div>
                <div>
                    <span style="font-size: 0.75rem; color: #64748B; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Email Address</span>
                    <strong style="color: #0F172A;">{{ $candidate->user->email }}</strong>
                </div>
                <div>
                    <span style="font-size: 0.75rem; color: #64748B; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Applied Date</span>
                    <span style="color: #475569;">{{ $candidate->created_at->format('M d, Y • h:i A') }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Right Column: Skills & Resume View --}}
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Matched & Missing Skills Breakdown -->
        <div class="glass-card" style="padding: 2rem;">
            <h3 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 1px solid #E2E8F0;">NLP Skill Breakdown</h3>
            
            <div style="margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.85rem; font-weight: 800; color: #059669; text-transform: uppercase; margin: 0 0 0.6rem 0;">Matched Skills Found</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @forelse((array)$candidate->parsed_skills as $skill)
                        <span style="padding: 4px 12px; background: #D1FAE5; color: #065F46; border-radius: 8px; font-size: 0.82rem; font-weight: 700; border: 1px solid #A7F3D0;">{{ $skill }}</span>
                    @empty
                        <span style="font-size: 0.88rem; color: #94A3B8;">No exact skill matches found in resume.</span>
                    @endforelse
                </div>
            </div>

            <div>
                <h4 style="font-size: 0.85rem; font-weight: 800; color: #DC2626; text-transform: uppercase; margin: 0 0 0.6rem 0;">Missing Skills</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @forelse((array)$candidate->missing_skills as $skill)
                        <span style="padding: 4px 12px; background: #FEE2E2; color: #991B1B; border-radius: 8px; font-size: 0.82rem; font-weight: 700; border: 1px solid #FECACA;">{{ $skill }}</span>
                    @empty
                        <span style="font-size: 0.88rem; color: #059669; font-weight: 700;">All required skills present!</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Resume File Card -->
        <div class="glass-card" style="padding: 2rem;">
            <h3 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 1px solid #E2E8F0;">Submitted Resume Document</h3>
            @if($candidate->resume_path)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #EEF2FF; color: #4F46E5; display: flex; align-items: center; justify-content: center;">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p style="margin: 0; font-weight: 800; color: #0F172A; font-size: 0.9rem;">Resume Document</p>
                            <p style="margin: 0; color: #64748B; font-size: 0.78rem;">PDF/DOCX Document File</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank" style="padding: 0.6rem 1.4rem; background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; border-radius: 50px; font-weight: 800; font-size: 0.85rem; text-decoration: none; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                        Download Resume 📄
                    </a>
                </div>
            @else
                <p style="color: #94A3B8; font-size: 0.9rem; margin: 0;">No resume document file uploaded.</p>
            @endif
        </div>

    </div>

</div>

@endsection
