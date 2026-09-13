<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobPosting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::with(['user', 'jobPosting']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }

        if ($request->filled('job')) {
            $query->where('job_posting_id', $request->job);
        }

        if ($request->filled('min_score')) {
            $query->where('match_score', '>=', $request->min_score);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $candidates = $query->orderByDesc('match_score')->paginate(3)->withQueryString();
        $jobs = JobPosting::orderBy('title')->get();

        return view('candidates.index', compact('candidates', 'jobs'));
    }

    public function myApplications()
    {
        $applications = Candidate::with('jobPosting')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(3);
        return view('candidates.my', compact('applications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'resume'         => 'required|file|mimes:pdf,docx|max:5120',
        ]);

        $user = auth()->user();

        // Prevent duplicate applications
        $exists = Candidate::where('user_id', $user->id)
                            ->where('job_posting_id', $request->job_posting_id)
                            ->exists();
        if ($exists) {
            return back()->with('error', 'You have already applied for this position.');
        }

        // Store resume
        $path = $request->file('resume')->store('resumes', 'public');

        $candidate = Candidate::create([
            'user_id'        => $user->id,
            'job_posting_id' => $request->job_posting_id,
            'resume_path'    => $path,
        ]);

        // Trigger AI analysis (calls Python microservice)
        $this->analyzeResume($candidate);

        ActivityLog::log(
            'Applied for Job',
            auth()->user()->name . ' applied for "' . ($candidate->jobPosting->title ?? 'a job') . '"',
            'Candidate', $candidate->id
        );

        return redirect()->route('candidates.my')
                         ->with('success', 'Application submitted! Your resume is being analyzed.');
    }

    public function show(Candidate $candidate)
    {
        $candidate->load(['user', 'jobPosting']);
        return view('candidates.show', compact('candidate'));
    }

    public function destroy(Candidate $candidate)
    {
        Storage::disk('public')->delete($candidate->resume_path);
        $candidate->delete();
        return back()->with('success', 'Application deleted.');
    }

    public function updateStatus(Request $request, Candidate $candidate)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Screened,Shortlisted,Interviewed,Rejected'
        ]);

        $candidate->update(['status' => $request->status]);

        ActivityLog::log(
            'Status Updated',
            auth()->user()->name . ' moved ' . ($candidate->user->name ?? 'candidate') . ' to "' . $request->status . '"',
            'Candidate', $candidate->id
        );

        return back()->with('success', 'Candidate status updated.');
    }

    public function exportCsv(Request $request)
    {
        $query = Candidate::with(['user', 'jobPosting']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }

        if ($request->filled('job')) {
            $query->where('job_posting_id', $request->job);
        }

        if ($request->filled('min_score')) {
            $query->where('match_score', '>=', $request->min_score);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $candidates = $query->orderByDesc('match_score')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=candidates_export.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($candidates) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Candidate Name', 'Email', 'Applied Job', 'Match Score', 'Status', 'Applied At']);

            foreach ($candidates as $c) {
                fputcsv($file, [
                    $c->id,
                    $c->user->name,
                    $c->user->email,
                    $c->jobPosting->title ?? 'N/A',
                    $c->match_score . '%',
                    $c->status,
                    $c->created_at->format('Y-m-d H:i')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function analyzeResume(Candidate $candidate): void
    {
        try {
            $job = $candidate->jobPosting;
            $resumePath = Storage::disk('public')->path($candidate->resume_path);

            // Check if file exists and call Python AI microservice
            if (!file_exists($resumePath)) {
                return;
            }

            $payload = json_encode([
                'resume_path'     => $resumePath,
                'job_description' => $job->description,
                'required_skills' => $job->required_skills,
            ]);

            $ch = curl_init('http://127.0.0.1:8001/analyze');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                $candidate->update([
                    'match_score'    => $data['match_score'] ?? null,
                    'parsed_skills'  => $data['extracted_skills'] ?? null,
                    'missing_skills' => $data['missing_skills'] ?? null,
                    'ai_advice'      => $data['ai_advice'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail – score stays null until service is available
        }
    }
}
