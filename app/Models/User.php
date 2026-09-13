<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'linkedin_url',
        'skills',
        'avatar',
        'default_resume',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function calculateProfileCompleteness(): int
    {
        $score = 0;
        
        // Base fields (assumed always there for registered users)
        if ($this->name) $score += 20;
        if ($this->email) $score += 20;

        // Optional fields
        if ($this->phone) $score += 5;
        if ($this->bio) $score += 15;
        if ($this->linkedin_url) $score += 5;
        if ($this->skills) $score += 10;
        if ($this->avatar) $score += 5;
        if ($this->default_resume) $score += 20;

        return min(100, $score);
    }
}
