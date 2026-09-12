<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'description'      => $this->description,
            'required_skills'  => $this->required_skills,
            'experience_level' => $this->experience_level,
            'posted_by'        => $this->whenLoaded('user', function () {
                return [
                    'id'   => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),
            'candidates_count' => $this->whenLoaded('candidates', fn() => $this->candidates->count()),
            'created_at'       => $this->created_at->toDateTimeString(),
        ];
    }
}
