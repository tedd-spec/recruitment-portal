@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-1">Job Listings</h1>
                    <p class="text-muted">Explore available career opportunities</p>
                </div>
            </div>
        </div>
    </div>

    @if($jobs->count() > 0)
        <div class="row">
            @foreach($jobs as $job)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="card-title mb-0 me-3">{{ $job->title }}</h5>
                                        <span class="badge bg-primary">{{ $job->job_code }}</span>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3 text-muted">
                                        <small class="me-3">
                                            <i class="bi bi-geo-alt"></i> {{ $job->location }}
                                        </small>
                                        <small class="me-3">
                                            <i class="bi bi-briefcase"></i> {{ $job->employment_type }}
                                        </small>
                                        <small>
                                            <i class="bi bi-currency-dollar"></i> {{ $job->formatted_salary }}
                                        </small>
                                    </div>
                                    
                                    <p class="card-text">{{ Str::limit($job->description, 200) }}</p>
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                        
                                        @auth
                                            @php
                                                $hasApplied = $job->applications()->where('user_id', auth()->id())->exists();
                                            @endphp
                                            
                                            @if(!$hasApplied)
                                                <a href="{{ route('applications.create', $job) }}" class="btn btn-success btn-sm">
                                                    Apply Now
                                                </a>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Applied
                                                </span>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                
                                @if($job->application_deadline)
                                    <div class="text-end">
                                        <small class="text-muted">Application Deadline</small>
                                        <div class="fw-bold">{{ $job->application_deadline->format('M d, Y') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $jobs->links() }}
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-search display-1 text-muted mb-3"></i>
                        <h3>No Jobs Available</h3>
                        <p class="text-muted">There are currently no job openings. Please check back later.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection