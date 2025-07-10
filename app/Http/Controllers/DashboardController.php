<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Initialize default values
        $totalApplications = collect(); // Empty collection
        $pendingApplications = 0;
        $shortlistedApplications = 0;
        $recentApplications = collect();
        $availableJobs = collect();

        // Fetch application data if model and table exist
        try {
            if (class_exists('App\Models\Application')) {
                $totalApplications = Application::where('user_id', $user->id)->get(); // Keep as collection
                $pendingApplications = Application::where('user_id', $user->id)
                    ->where('status', 'pending')->count();
                $shortlistedApplications = Application::where('user_id', $user->id)
                    ->where('status', 'shortlisted')->count();
                $recentApplications = Application::with('job')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::error('Application data not available: ' . $e->getMessage());
        }
        
        // Fetch job data if model and table exist
        try {
            if (class_exists('App\Models\Job')) {
                $availableJobs = Job::active()->latest()->take(5)->get();
            }
        } catch (\Exception $e) {
            \Log::error('Job data not available: ' . $e->getMessage());
        }

        return view('dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'shortlistedApplications',
            'recentApplications',
            'availableJobs'
        ));
    }
}