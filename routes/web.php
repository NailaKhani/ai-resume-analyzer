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
    Route::get('/candidates/export', [CandidateController::class, 'exportCsv'])->name('candidates.export');
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('candidates.store');
    Route::patch('/candidates/{candidate}/status', [CandidateController::class, 'updateStatus'])->name('candidates.status');
    Route::get('/candidates/my', [CandidateController::class, 'myApplications'])->name('candidates.my');
    Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
});

require __DIR__.'/auth.php';

// Sandbox Route
Route::post('/sandbox/analyze', [\App\Http\Controllers\SandboxController::class, 'analyze'])->name('sandbox.analyze');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-role', [\App\Http\Controllers\AdminController::class, 'toggleRole'])->name('users.toggle-role');
    Route::get('/activity', [\App\Http\Controllers\AdminController::class, 'activityLogs'])->name('activity');
});
