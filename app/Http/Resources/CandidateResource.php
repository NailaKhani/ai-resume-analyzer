<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'job_posting_id' => $this->job_posting_id,
            'job_title'      => $this->whenLoaded('jobPosting', fn() => $this->jobPosting->title),
            'candidate'      => $this->whenLoaded('user', function () {
                return [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'resume_url'     => $this->resume_path ? url('storage/' . $this->resume_path) : null,
            'parsed_skills'  => $this->parsed_skills,
            'match_score'    => $this->match_score,
            'applied_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}
