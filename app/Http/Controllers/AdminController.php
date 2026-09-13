<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Candidate;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (auth()->user()->role !== 'admin') {
                    abort(403, 'Admin access only.');
                }
                return $next($request);
            }),
        ];
    }

    public function dashboard()
    {
        $stats = [
            'total_users'      => User::count(),
            'hr_users'         => User::where('role', 'hr')->count(),
            'candidates'       => User::where('role', 'candidate')->count(),
            'total_jobs'       => JobPosting::count(),
            'total_apps'       => Candidate::count(),
            'avg_score'        => round(Candidate::whereNotNull('match_score')->avg('match_score') ?? 0, 1),
            'shortlisted'      => Candidate::where('status', 'Shortlisted')->count(),
            'this_month_apps'  => Candidate::whereMonth('created_at', now()->month)->count(),
        ];

        // Chart: applications per day (last 7 days)
        $applicationsPerDay = Candidate::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chart: status distribution
        $statusDist = Candidate::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Recent activity
        $recentActivity = ActivityLog::with('user')->latest()->take(15)->get();

        // All users (paginated)
        $users = User::latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'applicationsPerDay', 'statusDist', 'recentActivity', 'users'));
    }

    public function users()
    {
        $users = User::withCount(['candidates'])->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        ActivityLog::log('User Deleted', auth()->user()->name . ' deleted user ' . $user->name, 'User', $user->id);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot change your own role.');
        }
        $newRole = $user->role === 'hr' ? 'candidate' : 'hr';
        $user->update(['role' => $newRole]);
        ActivityLog::log('Role Changed', auth()->user()->name . ' changed ' . $user->name . '\'s role to ' . $newRole, 'User', $user->id);
        return back()->with('success', 'User role updated.');
    }

    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity', compact('logs'));
    }
}
