@extends('layouts.app')
@section('title', $candidate->user->name . ' – Application')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('candidates.index') }}" class="p-2 rounded-lg hover:bg-violet-100 text-slate-500 hover:text-violet-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ $candidate->user->name }}</h1>
            <p class="text-slate-500 mt-1">Application for: <strong class="text-slate-700">{{ $candidate->jobPosting->title ?? '–' }}</strong></p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('candidates.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition text-sm font-medium">Back to List</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left: Match Score & Info (1/3 width) --}}
    <div class="space-y-6">
        <div class="glass-panel p-6 text-center">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">AI Match Score</h2>
            @if($candidate->match_score !== null)
                @php
                    $score = $candidate->match_score;
                    $colors = $score >= 75 ? ['text'=>'text-emerald-600', 'bg'=>'bg-emerald-500', 'desc'=>'Strong match for this position', 'light'=>'bg-emerald-100'] : 
                              ($score >= 50 ? ['text'=>'text-amber-600', 'bg'=>'bg-amber-500', 'desc'=>'Moderate match — review skills gap', 'light'=>'bg-amber-100'] : 
                              ['text'=>'text-red-600', 'bg'=>'bg-red-500', 'desc'=>'Low match — may not meet requirements', 'light'=>'bg-red-100']);
                @endphp
                <div class="text-6xl font-extrabold tracking-tight {{ $colors['text'] }} mb-2">{{ number_format($score, 1) }}%</div>
                <p class="text-sm text-slate-500 mb-6 px-4">{{ $colors['desc'] }}</p>
                <div class="w-full bg-slate-100 rounded-full h-3 max-w-[220px] mx-auto">
                    <div class="{{ $colors['bg'] }} h-3 rounded-full transition-all duration-1000" style="width: {{ min($score, 100) }}%"></div>
                </div>
            @else
                <div class="py-8">
                    <div class="animate-spin w-10 h-10 border-4 border-violet-200 border-t-violet-600 rounded-full mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Resume is being analyzed...</p>
                </div>
            @endif
        </div>

        <div class="glass-panel p-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Candidate Info</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Name</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $candidate->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Email</p>
                    <p class="text-sm font-semibold text-slate-800 break-all">{{ $candidate->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Applied For</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $candidate->jobPosting->title ?? '–' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Applied On</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $candidate->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            @if($candidate->resume_path)
                <div class="mt-6 pt-4 border-t border-purple-100">
                    <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank" class="btn-primary w-full flex justify-center items-center gap-2 py-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download Resume
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Right: Skill Analysis (2/3 width) --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="glass-panel p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b border-purple-100">Required Skills for This Job</h2>
            @if($candidate->jobPosting)
                @php $required = explode(',', $candidate->jobPosting->required_skills); @endphp
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($required as $skill)
                        @php 
                            $s = trim($skill); 
                            $extracted = array_map('strtolower', (array)($candidate->parsed_skills ?? []));
                            $matched = in_array(strtolower($s), $extracted);
                        @endphp
                        <span class="px-3 py-1.5 rounded-lg text-sm font-medium border {{ $matched ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                            @if($matched)
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            @endif
                            {{ $s }}
                        </span>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500 flex items-center gap-4">
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Matched in resume</span>
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block"></span> Missing</span>
                </p>
            @endif
        </div>

        <div class="glass-panel p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b border-purple-100">All Extracted Skills from Resume</h2>
            @if($candidate->parsed_skills && count((array)$candidate->parsed_skills) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach((array)$candidate->parsed_skills as $skill)
                        <span class="px-3 py-1.5 rounded-lg text-sm font-medium bg-violet-100 text-violet-700 border border-violet-200">{{ $skill }}</span>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-slate-500 text-sm">No skills extracted yet. Analysis may still be in progress.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
