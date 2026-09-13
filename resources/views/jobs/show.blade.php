@extends('layouts.app')
@section('title', $job->title)

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 mb-1">
            @php $expColors = ['entry'=>'bg-emerald-100 text-emerald-700 border-emerald-200','mid'=>'bg-blue-100 text-blue-700 border-blue-200','senior'=>'bg-amber-100 text-amber-700 border-amber-200']; @endphp
            <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold border {{ $expColors[$job->experience_level] ?? 'bg-slate-100 text-slate-600' }}">
                {{ ucfirst($job->experience_level) }} Level
            </span>
            <span class="text-xs text-slate-400">Posted {{ $job->created_at->diffForHumans() }} by {{ $job->user->name }}</span>
        </div>
        <h1 class="text-3xl font-bold text-slate-800">{{ $job->title }}</h1>
    </div>
    <div class="flex items-center gap-2">
        @if(auth()->user()->role !== 'candidate')
            <a href="{{ route('jobs.edit', $job->id) }}" class="btn-primary px-5 py-2.5 text-sm">Edit Job</a>
        @endif
        <a href="{{ route('jobs.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition text-sm font-medium">Back</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Left: Job Details (2/3 width) --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="glass-panel p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b border-purple-100">Job Details</h2>
            <div class="space-y-4">
                <div class="flex gap-4">
                    <span class="text-sm text-slate-500 font-medium w-36 flex-shrink-0">Experience Level</span>
                    <span class="text-sm px-2.5 py-0.5 rounded-full font-semibold border {{ $expColors[$job->experience_level] ?? '' }}">{{ ucfirst($job->experience_level) }}</span>
                </div>
                <div class="flex gap-4">
                    <span class="text-sm text-slate-500 font-medium w-36 flex-shrink-0">Required Skills</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach(explode(',', $job->required_skills) as $skill)
                            <span class="text-xs px-2 py-0.5 rounded-md bg-violet-100 text-violet-700 font-medium">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b border-purple-100">Job Description</h2>
            <p class="text-slate-600 leading-relaxed whitespace-pre-wrap text-sm">{{ $job->description }}</p>
        </div>
    </div>

    {{-- Right: Apply / Candidates (1/3 width) --}}
    <div class="space-y-6">
        @if(auth()->user()->role === 'candidate')
        <div class="glass-panel p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b border-purple-100">Apply for this Position</h2>
            @if($alreadyApplied)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-center">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-emerald-800 font-semibold text-sm">Already Applied!</p>
                    <p class="text-emerald-600 text-xs mt-1">Our AI is analyzing your resume and will update your match score shortly.</p>
                </div>
            @else
                <p class="text-slate-500 text-sm mb-5">Upload your resume. Our AI will analyze and calculate your match score instantly.</p>
                <form method="POST" action="{{ route('candidates.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_posting_id" value="{{ $job->id }}">
                    <div class="mb-5">
                        <label for="resume" class="block text-sm font-semibold text-slate-700 mb-2">Resume File</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-purple-200 border-dashed rounded-xl bg-violet-50/50 hover:bg-violet-50 transition cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <div class="text-sm text-slate-600">
                                    <label for="resume" class="relative cursor-pointer text-violet-600 font-semibold hover:text-violet-800">
                                        <span>Upload a file</span>
                                        <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf,.docx">
                                    </label>
                                    <span class="text-slate-400"> or drag and drop</span>
                                </div>
                                <p class="text-xs text-slate-400">PDF, DOCX up to 5MB</p>
                            </div>
                        </div>
                        @error('resume') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full py-3 text-center">Submit Application</button>
                </form>
            @endif
        </div>

        @else
        {{-- HR sees applicants --}}
        <div class="glass-panel overflow-hidden">
            <div class="px-6 py-4 border-b border-purple-100">
                <h2 class="text-lg font-bold text-slate-800">Applicants ({{ $job->candidates->count() }})</h2>
            </div>
            @if($job->candidates->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-slate-400 text-sm">No applicants yet. Candidates will appear here once they apply.</p>
                </div>
            @else
                <div class="divide-y divide-purple-50">
                    @foreach($job->candidates as $c)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-violet-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($c->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">{{ $c->user->name }}</p>
                                <p class="text-slate-400 text-xs">{{ $c->user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($c->match_score !== null)
                                <span class="text-sm font-bold text-violet-700">{{ number_format($c->match_score, 1) }}%</span>
                            @else
                                <span class="text-xs text-slate-400 italic">Analyzing...</span>
                            @endif
                            <a href="{{ route('candidates.show', $c->id) }}" class="px-3 py-1.5 rounded-lg bg-violet-50 text-violet-700 border border-violet-200 hover:bg-violet-100 transition text-xs font-semibold">Review</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
