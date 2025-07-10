<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::active()->latest()->paginate(10);
        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        if (!$job->is_active) {
            abort(404);
        }
        
        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_code' => 'required|string|unique:jobs',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'employment_type' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'application_deadline' => 'nullable|date|after:today',
        ]);

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }
}