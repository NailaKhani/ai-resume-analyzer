<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Candidate;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalJobs = JobPosting::count();

        if ($user->role === 'candidate') {
            $myApplications = Candidate::where('user_id', $user->id)->count();
            $bestScore = Candidate::where('user_id', $user->id)->max('match_score') ?? 0;
            $latestJobs = JobPosting::latest()->take(5)->get();
            return view('dashboard', compact('totalJobs', 'myApplications', 'bestScore', 'latestJobs'));
        }

        $totalCandidates = Candidate::count();
        $avgScore = round(Candidate::whereNotNull('match_score')->avg('match_score') ?? 0, 1);
        $recentCandidates = Candidate::with(['user', 'jobPosting'])->latest()->take(5)->get();

        return view('dashboard', compact('totalJobs', 'totalCandidates', 'avgScore', 'recentCandidates'));
    }
}
