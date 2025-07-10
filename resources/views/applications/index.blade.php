@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-1">My Applications</h1>
            <p class="text-muted">Track the status of your job applications</p>
        </div>
    </div>

    @if($applications->count() > 0)
        <div class="row">
            @foreach($applications as $application)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="card-title mb-0 me-3">{{ $application->job->title }}</h5>
                                        <span class="badge bg-primary">{{ $application->job->job_code }}</span>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3 text-muted">
                                        <small class="me-3">
                                            <i class="bi bi-geo-alt"></i> {{ $application->job->location }}
                                        </small>
                                        <small class="me-3">
                                            <i class="bi bi-calendar"></i> Applied {{ $application->created_at->format('M d, Y') }}
                                        </small>
                                        <small>
                                            <i class="bi bi-clock"></i> {{ $application->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge {{ $application->status_badge_class }} me-2">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                        
                                        @if($application->status === 'pending')
                                            <small class="text-warning">Under Review</small>
                                        @elseif($application->status === 'shortlisted')
                                            <small class="text-success">🎉 Congratulations! You've been shortlisted</small>
                                        @elseif($application->status === 'rejected')
                                            <small class="text-danger">Application not successful this time</small>
                                        @elseif($application->status === 'hired')
                                            <small class="text-success">🎉 Congratulations! You've been hired</small>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('applications.show', $application) }}" class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                        
                                        @if($application->resume_path)
                                            <a href="{{ route('applications.download-resume', $application) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-file-earmark-arrow-down"></i> Download Resume
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-outline-info btn-sm">
                                            View Job Posting
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <small class="text-muted">Application ID</small>
                                    <div class="fw-bold">#{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $applications->links() }}
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-file-text display-1 text-muted mb-3"></i>
                        <h3>No Applications Yet</h3>
                        <p class="text-muted mb-4">You haven't applied for any jobs yet. Start exploring opportunities!</p>
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                            <i class="bi bi-briefcase"></i> Browse Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection