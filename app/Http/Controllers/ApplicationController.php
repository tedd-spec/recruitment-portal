<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ✅ Fix: Applications index for route('applications.index')
     */
    public function index()
    {
        // Optional: Add admin-only logic here later
        $applications = Application::with('job')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function create(Job $job)
    {
        $existingApplication = Application::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this position.');
        }

        return view('applications.create', compact('job'));
    }

    public function store(Request $request, Job $job)
    {
        $existingApplication = Application::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this position.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'education_level' => 'required|string',
            'work_experience' => 'required|string',
            'skills' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string'
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'education_level' => $validated['education_level'],
            'work_experience' => $validated['work_experience'],
            'skills' => $validated['skills'],
            'resume_path' => $resumePath,
            'cover_letter' => $validated['cover_letter'] ?? null,
        ]);

        return redirect()->route('applications.index')
            ->with('success', 'Application submitted successfully!');
    }

    public function myApplications()
    {
        $applications = Application::with('job')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('applications.show', compact('application'));
    }

    public function downloadResume(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$application->resume_path || !Storage::disk('public')->exists($application->resume_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($application->resume_path);
    }
}
