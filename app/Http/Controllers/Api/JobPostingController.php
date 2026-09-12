<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Http\Resources\JobPostingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::with('user', 'candidates');

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

        $jobs = $query->latest()->paginate(10);
        return JobPostingResource::collection($jobs);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'candidate') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'required_skills'  => 'required|string',
            'experience_level' => 'required|in:entry,mid,senior',
        ]);

        $validated['user_id'] = Auth::id();
        $job = JobPosting::create($validated);

        return new JobPostingResource($job);
    }

    public function show(JobPosting $job)
    {
        $job->load('user', 'candidates');
        return new JobPostingResource($job);
    }

    public function update(Request $request, JobPosting $job)
    {
        if (Auth::user()->role === 'candidate') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title'            => 'sometimes|required|string|max:255',
            'description'      => 'sometimes|required|string',
            'required_skills'  => 'sometimes|required|string',
            'experience_level' => 'sometimes|required|in:entry,mid,senior',
        ]);

        $job->update($validated);
        return new JobPostingResource($job);
    }

    public function destroy(JobPosting $job)
    {
        if (Auth::user()->role === 'candidate') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $job->delete();
        return response()->json(['message' => 'Job posting deleted']);
    }
}
