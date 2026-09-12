<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'required_skills',
        'experience_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
