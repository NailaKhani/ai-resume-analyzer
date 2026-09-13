<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SandboxController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,docx|max:5120',
            'job_description' => 'required|string',
            'required_skills' => 'required|string',
        ]);

        $path = $request->file('resume')->store('temp_sandbox');
        $resumePath = Storage::disk('local')->path($path); // get absolute path

        try {
            $payload = json_encode([
                'resume_path'     => $resumePath,
                'job_description' => $request->job_description,
                'required_skills' => $request->required_skills,
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

            // Cleanup temp file
            Storage::disk('local')->delete($path);

            if ($httpCode === 200 && $response) {
                return response()->json(json_decode($response, true));
            }

            return response()->json(['error' => 'AI Service Error'], 500);

        } catch (\Exception $e) {
            Storage::disk('local')->delete($path);
            return response()->json(['error' => 'Failed to connect to AI Service'], 500);
        }
    }
}
