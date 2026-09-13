<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'job_posting_id',
        'resume_path',
        'parsed_skills',
        'missing_skills',
        'ai_advice',
        'match_score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'parsed_skills' => 'array',
            'missing_skills' => 'array',
            'match_score' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
