<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Welcome / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Job Postings (full CRUD)
    Route::resource('jobs', JobPostingController::class);

    // Candidates
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('candidates.store');
    Route::get('/candidates/my', [CandidateController::class, 'myApplications'])->name('candidates.my');
    Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
});

require __DIR__.'/auth.php';
