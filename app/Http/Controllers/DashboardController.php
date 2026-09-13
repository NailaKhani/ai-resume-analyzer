<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Candidate;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalJobs = JobPosting::count();

        if ($user->role === 'candidate') {
            $myApplications = Candidate::where('user_id', $user->id)->count();
            $bestScore = Candidate::where('user_id', $user->id)->max('match_score') ?? 0;
            $latestJobs = JobPosting::latest()->take(6)->get();
            $recentApplications = Candidate::with('jobPosting')
                ->where('user_id', $user->id)
                ->latest()
                ->take(4)
                ->get();

            // Chart data: score history
            $scoreHistory = Candidate::with('jobPosting')
                ->where('user_id', $user->id)
                ->whereNotNull('match_score')
                ->latest()
                ->take(6)
                ->get()
                ->map(fn($c) => [
                    'label' => $c->jobPosting->title ?? 'Job',
                    'score' => round($c->match_score, 1),
                ]);

            return view('dashboard', compact(
                'totalJobs', 'myApplications', 'bestScore',
                'latestJobs', 'recentApplications', 'scoreHistory'
            ));
        }

        // HR / Admin dashboard
        $totalCandidates = Candidate::count();
        $avgScore = round(Candidate::whereNotNull('match_score')->avg('match_score') ?? 0, 1);
        $recentCandidates = Candidate::with(['user', 'jobPosting'])->latest()->take(5)->get();

        // Chart 1: Applications per job (top 6)
        $applicationsPerJob = Candidate::select('job_posting_id', DB::raw('count(*) as total'))
            ->with('jobPosting')
            ->groupBy('job_posting_id')
            ->orderByDesc('total')
            ->take(6)
            ->get()
            ->map(fn($c) => [
                'label' => $c->jobPosting->title ?? 'Unknown',
                'value' => $c->total,
            ]);

        // Chart 2: Candidate status distribution
        $statusDistribution = Candidate::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(fn($c) => [
                'label' => $c->status,
                'value' => $c->total,
            ]);

        // Chart 3: Top match scores per job
        $topScoresByJob = Candidate::select('job_posting_id', DB::raw('max(match_score) as best_score'))
            ->with('jobPosting')
            ->whereNotNull('match_score')
            ->groupBy('job_posting_id')
            ->orderByDesc('best_score')
            ->take(6)
            ->get()
            ->map(fn($c) => [
                'label' => $c->jobPosting->title ?? 'Unknown',
                'score' => round($c->best_score, 1),
            ]);

        // Recent activity logs
        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Total users
        $totalUsers = User::where('role', 'candidate')->count();

        return view('dashboard', compact(
            'totalJobs', 'totalCandidates', 'avgScore', 'recentCandidates',
            'applicationsPerJob', 'statusDistribution', 'topScoresByJob',
            'recentActivity', 'totalUsers'
        ));
    }
}
