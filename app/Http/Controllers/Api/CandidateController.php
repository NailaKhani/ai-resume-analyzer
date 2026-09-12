<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'candidate') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Candidate::with(['user', 'jobPosting']);

        if ($request->filled('job')) {
            $query->where('job_posting_id', $request->job);
        }

        $candidates = $query->orderByDesc('match_score')->paginate(10);
        return CandidateResource::collection($candidates);
    }

    public function myApplications()
    {
        $applications = Candidate::with('jobPosting')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return CandidateResource::collection($applications);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'candidate') {
            return response()->json(['message' => 'Only candidates can apply for jobs.'], 403);
        }

        $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'resume'         => 'required|file|mimes:pdf,docx|max:5120',
        ]);

        $exists = Candidate::where('user_id', Auth::id())
                            ->where('job_posting_id', $request->job_posting_id)
                            ->exists();
        if ($exists) {
            return response()->json(['message' => 'You have already applied for this position.'], 400);
        }

        $path = $request->file('resume')->store('resumes', 'public');

        $candidate = Candidate::create([
            'user_id'        => Auth::id(),
            'job_posting_id' => $request->job_posting_id,
            'resume_path'    => $path,
        ]);

        // Trigger AI analysis asynchronously if available
        $this->analyzeResume($candidate);

        return response()->json([
            'message'   => 'Application submitted successfully.',
            'candidate' => new CandidateResource($candidate->load('jobPosting'))
        ], 201);
    }

    public function show(Candidate $candidate)
    {
        $candidate->load(['user', 'jobPosting']);
        return new CandidateResource($candidate);
    }

    public function destroy(Candidate $candidate)
    {
        if (Auth::user()->role === 'candidate' && $candidate->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($candidate->resume_path) {
            Storage::disk('public')->delete($candidate->resume_path);
        }
        $candidate->delete();

        return response()->json(['message' => 'Application removed successfully.']);
    }

    private function analyzeResume(Candidate $candidate): void
    {
        try {
            $job = $candidate->jobPosting;
            $resumePath = Storage::disk('public')->path($candidate->resume_path);

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
            curl_setopt($ch, CURLOPT_TIMEOUT, 3); // short timeout for API response

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                $candidate->update([
                    'match_score'   => $data['match_score'] ?? null,
                    'parsed_skills' => $data['extracted_skills'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail
        }
    }
}
