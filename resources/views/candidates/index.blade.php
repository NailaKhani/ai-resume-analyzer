@extends('layouts.app')
@section('title', 'Candidate Applications')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Candidate Applications</h1>
        <p class="text-slate-500 mt-1">All applications ranked by AI match score.</p>
    </div>
    <a href="{{ route('candidates.export', request()->all()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-700 transition">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Export CSV
    </a>
</div>

{{-- Filter --}}
<div class="glass-panel p-5 mb-6">
    <form method="GET" action="{{ route('candidates.index') }}">
        <div class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Search by Name or Email</label>
                <input type="text" name="search"
                    class="w-full px-4 py-2.5 rounded-lg border border-purple-200 bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition text-sm"
                    placeholder="Candidate name or email..." value="{{ request('search') }}">
            </div>
            <div class="w-full sm:w-48">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Filter by Job</label>
                <select name="job" class="w-full px-4 py-2.5 rounded-lg border border-purple-200 bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition text-sm">
                    <option value="">All Jobs</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ request('job') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-48" x-data="{ score: {{ request('min_score', 0) }} }">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    Min Score: <span x-text="score + '%'" class="text-violet-700"></span>
                </label>
                <input type="range" name="min_score" min="0" max="100" step="5" x-model="score" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer mt-3">
            </div>
            <div class="w-full sm:w-40">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-purple-200 bg-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition text-sm">
                    <option value="">All Statuses</option>
                    @foreach(['Pending','Screened','Shortlisted','Interviewed','Rejected'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary px-5 py-2.5 text-sm">Filter</button>
                @if(request('search') || request('job'))
                    <a href="{{ route('candidates.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition text-sm font-medium">Clear</a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Candidates --}}
@if($candidates->isEmpty())
    <div class="glass-panel p-16 text-center">
        <div class="w-16 h-16 bg-violet-100 rounded-2xl mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-slate-700 mb-2">No candidates found</h3>
        <p class="text-slate-500">No applications match your search criteria.</p>
    </div>
@else
    <div class="glass-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Applied For</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">AI Match Score</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Matched Skills</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Applied</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50">
                    @foreach($candidates as $c)
                    <tr class="hover:bg-violet-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($c->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $c->user->name }}</p>
                                    <p class="text-slate-400 text-xs">{{ $c->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $c->jobPosting->title ?? '–' }}</td>
                        <td class="px-6 py-4">
                            @if($c->match_score !== null)
                                <div class="flex items-center gap-2 cursor-pointer" x-data @click="$dispatch('open-modal-{{ $c->id }}')">
                                    <div class="w-24 bg-slate-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 h-2 rounded-full" style="width: {{ min($c->match_score, 100) }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-violet-700 hover:underline">{{ number_format($c->match_score, 1) }}%</span>
                                </div>
                                <x-match-breakdown-modal :candidate="$c" />
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Pending AI</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('candidates.status', $c->id) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-full px-2 py-1 border-slate-200 bg-slate-50 focus:ring-violet-500 focus:border-violet-500">
                                    @foreach(['Pending','Screened','Shortlisted','Interviewed','Rejected'] as $st)
                                        <option value="{{ $st }}" {{ $c->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if($c->parsed_skills)
                                    @foreach(array_slice((array)$c->parsed_skills, 0, 3) as $skill)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-violet-100 text-violet-700">{{ $skill }}</span>
                                    @endforeach
                                    @if(count((array)$c->parsed_skills) > 3)
                                        <span class="text-xs text-slate-400">+{{ count((array)$c->parsed_skills) - 3 }}</span>
                                    @endif
                                @else
                                    <span class="text-slate-400 text-xs">–</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $c->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('candidates.show', $c->id) }}" class="px-3 py-1.5 rounded-lg bg-violet-50 text-violet-700 border border-violet-200 hover:bg-violet-100 transition text-xs font-semibold">Review</a>
                                <form method="POST" action="{{ route('candidates.destroy', $c->id) }}" onsubmit="return confirm('Remove this application?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition text-xs font-semibold">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-purple-100">{{ $candidates->links() }}</div>
    </div>
@endif
@endsection
