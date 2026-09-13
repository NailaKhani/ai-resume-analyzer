<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="glass-panel p-6 border-l-4 border-violet-500 hover:scale-105 transition-transform duration-300">
        <h3 class="text-lg font-medium text-slate-500 mb-1">My Applications</h3>
        <p class="text-4xl font-bold text-violet-700">{{ $applicationsCount }}</p>
    </div>
    <div class="glass-panel p-6 border-l-4 border-fuchsia-500 hover:scale-105 transition-transform duration-300 bg-gradient-to-r from-white/40 to-fuchsia-50/40">
        <h3 class="text-lg font-medium text-slate-700 mb-2">Ready to apply?</h3>
        <a href="{{ route('candidates.index') }}" class="btn-primary inline-block">Browse Available Jobs</a>
    </div>
</div>

<div class="glass-panel overflow-hidden">
    <div class="px-6 py-5 border-b border-purple-100 flex justify-between items-center bg-white/40">
        <h3 class="text-lg font-semibold text-slate-800">My Recent Applications</h3>
    </div>
    <div class="p-6">
        @if($recentApplications->isEmpty())
            <div class="text-center py-10">
                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-slate-500 text-lg">You haven't applied to any jobs yet.</p>
                <a href="{{ route('candidates.index') }}" class="text-violet-600 hover:text-violet-800 font-medium mt-2 inline-block">Find your first job &rarr;</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-purple-100">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Job Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">AI Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Applied</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-50">
                        @foreach($recentApplications as $candidate)
                            <tr class="hover:bg-purple-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $candidate->jobPosting->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($candidate->match_score !== null)
                                        <div class="flex items-center">
                                            <div class="w-full bg-slate-200 rounded-full h-2.5 mr-2 max-w-[100px]">
                                              <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 h-2.5 rounded-full" style="width: {{ $candidate->match_score }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-violet-700">{{ $candidate->match_score }}%</span>
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">Processing...</span>
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
