<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('required_skills', 'like', "%{$search}%");
            });
        }

        if ($request->filled('experience')) {
            $query->where('experience_level', $request->experience);
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'required_skills'  => 'required|string',
            'experience_level' => 'required|in:entry,mid,senior',
        ]);

        $validated['user_id'] = auth()->id();
        JobPosting::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posting created successfully.');
    }

    public function show(JobPosting $job)
    {
        $job->load('candidates.user');
        $alreadyApplied = auth()->check()
            ? $job->candidates()->where('user_id', auth()->id())->exists()
            : false;
        return view('jobs.show', compact('job', 'alreadyApplied'));
    }

    public function edit(JobPosting $job)
    {
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, JobPosting $job)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'required_skills'  => 'required|string',
            'experience_level' => 'required|in:entry,mid,senior',
        ]);

        $job->update($validated);
        return redirect()->route('jobs.index')->with('success', 'Job posting updated successfully.');
    }

    public function destroy(JobPosting $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job posting deleted.');
    }
}
