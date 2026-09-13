<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 border-l-4 border-violet-500 hover:scale-105 transition-transform duration-300">
        <h3 class="text-lg font-medium text-slate-500 mb-1">Total Jobs</h3>
        <p class="text-4xl font-bold text-violet-700">{{ $jobsCount }}</p>
    </div>
    <div class="glass-panel p-6 border-l-4 border-fuchsia-500 hover:scale-105 transition-transform duration-300">
        <h3 class="text-lg font-medium text-slate-500 mb-1">Total Applications</h3>
        <p class="text-4xl font-bold text-fuchsia-700">{{ $applicationsCount }}</p>
    </div>
</div>

<div class="glass-panel overflow-hidden">
    <div class="px-6 py-5 border-b border-purple-100 flex justify-between items-center bg-white/40">
        <h3 class="text-lg font-semibold text-slate-800">Recent Applications</h3>
        <a href="{{ route('jobs.index') }}" class="text-sm text-violet-600 hover:text-violet-800 font-medium">View All Jobs &rarr;</a>
    </div>
    <div class="p-6">
        @if($recentApplications->isEmpty())
            <p class="text-slate-500 text-center py-8">No recent applications found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-purple-100">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Candidate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Job</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">AI Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Applied</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-50">
                        @foreach($recentApplications as $candidate)
                            <tr class="hover:bg-purple-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $candidate->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $candidate->jobPosting->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($candidate->match_score !== null)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-fuchsia-100 text-fuchsia-800 border border-fuchsia-200">
                                            {{ $candidate->match_score }}% Match
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $candidate->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
