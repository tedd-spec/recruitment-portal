@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Main -->
        <main class="col-md-12 px-md-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pt-3 pb-2 mb-3">
                <h1 class="h4">Welcome to the EACC Recruitment Portal</h1>
            </div>

            <p class="text-muted">Hello {{ Auth::user()->name }}! Manage your job applications and explore career opportunities.</p>

            {{-- Statistics Cards --}}
            <div class="row mb-4">
                @php
                    $stats = [
                        ['label' => 'Total Applications', 'value' => $totalApplications ?? 0, 'color' => 'primary', 'text' => 'All your job applications'],
                        ['label' => 'Pending Review', 'value' => $pendingApplications ?? 0, 'color' => 'warning', 'text' => 'Applications under review'],
                        ['label' => 'Shortlisted', 'value' => $shortlistedApplications ?? 0, 'color' => 'success', 'text' => 'Applications shortlisted'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-{{ $stat['color'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <span class="text-white fw-bold">{{ $stat['value'] }}</span>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-1">{{ $stat['label'] }}</h5>
                                <p class="text-muted small">{{ $stat['text'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <!-- Left Column: Profile + Form -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">My Profile</h5>
                        </div>
                        <div class="card-body">
                            <h6>Upload Resume</h6>
                            <form id="resumeUploadForm" action="{{ route('profile.uploadResume') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="resume" class="form-label">Upload Your Resume (PDF)</label>
                                    <input type="file" class="form-control" id="resume" name="resume" accept=".pdf" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>

                            <hr>

                            <h6>Apply for a Job</h6>
                            <form id="applicationForm" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="skills" class="form-label">Skills</label>
                                    <textarea class="form-control" id="skills" name="skills" rows="3">{{ old('skills') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Experience</label>
                                    <textarea class="form-control" id="experience" name="experience" rows="3">{{ old('experience') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="job_id" class="form-label">Select Job</label>
                                    <select class="form-select" id="job_id" name="job_id" required>
                                        <option value="">Select a job</option>
                                        @foreach ($availableJobs as $job)
                                            <option value="{{ $job->id }}">{{ $job->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Submit Application</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Applications & Job Openings -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header border-bottom-0">
                            <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="applications-tab" data-bs-toggle="tab" data-bs-target="#applications" type="button" role="tab">Applications</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button" role="tab">Job Openings</button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body tab-content" id="dashboardTabsContent">
                            <!-- Applications Tab -->
                            <div class="tab-pane fade show active" id="applications" role="tabpanel">
                                @if(isset($recentApplications) && $recentApplications->count() > 0)
                                    @foreach($recentApplications as $application)
                                        <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-dark rounded text-white">
                                            <div>
                                                <h6 class="mb-1">{{ $application->job->title ?? 'Job Title' }}</h6>
                                                <small>{{ $application->job->job_code ?? 'N/A' }} • {{ $application->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="badge {{ $application->status_badge_class ?? 'bg-secondary' }}">
                                                {{ ucfirst($application->status ?? 'pending') }}
                                            </span>
                                        </div>
                                    @endforeach
                                    <div class="mt-3">
                                        <a href="{{ route('applications.index') }}" class="btn btn-outline-primary btn-sm">View all applications</a>
                                    </div>
                                @else
                                    <p class="text-muted">No applications yet. <a href="{{ route('jobs.index') }}" class="text-decoration-none">Browse jobs</a> to get started.</p>
                                @endif
                            </div>

                            <!-- Job Openings Tab -->
                            <div class="tab-pane fade" id="jobs" role="tabpanel">
                                @if(isset($availableJobs) && $availableJobs->count() > 0)
                                    @foreach($availableJobs as $job)
                                        <div class="p-3 mb-2 bg-dark rounded text-white">
                                            <h6 class="mb-1">{{ $job->title }}</h6>
                                            <small>{{ $job->job_code }} • {{ $job->location }}</small>
                                            <div class="mt-2">
                                                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-light btn-sm">View Details</a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-3">
                                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm">View all jobs</a>
                                    </div>
                                @else
                                    <p class="text-muted">No jobs available at the moment. Check back later!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.getElementById('resumeUploadForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await response.json();
            if (data.success && data.parsedData) {
                const parsed = data.parsedData;
                if (parsed.name) document.getElementById('name').value = parsed.name;
                if (parsed.email) document.getElementById('email').value = parsed.email;
                if (parsed.skills) document.getElementById('skills').value = parsed.skills;
                if (parsed.experience) document.getElementById('experience').value = parsed.experience;
                alert('Resume parsed successfully!');
            } else {
                alert('Error parsing resume: ' + (data.error || 'Unknown error.'));
            }
        } catch (error) {
            alert('Error uploading resume: ' + error.message);
        }
    });

    document.getElementById('applicationForm').addEventListener('submit', function (e) {
        const selectedJobId = document.getElementById('job_id').value;
        if (!selectedJobId) {
            e.preventDefault();
            alert('Please select a job before submitting your application.');
            return;
        }
        this.action = `/jobs/${selectedJobId}/apply`;
    });
</script>
@endsection