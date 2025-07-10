@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $job->title }}</h3>
                            <span class="badge bg-primary">{{ $job->job_code }}</span>
                        </div>
                        @auth
                            @php
                                $hasApplied = $job->applications()->where('user_id', auth()->id())->exists();
                            @endphp
                            
                            @if(!$hasApplied)
                                <a href="{{ route('applications.create', $job) }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-plus"></i> Apply Now
                                </a>
                            @else
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle"></i> Applied
                                </span>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Job Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><i class="bi bi-geo-alt"></i> Location</h6>
                            <p>{{ $job->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-briefcase"></i> Employment Type</h6>
                            <p>{{ $job->employment_type }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-currency-dollar"></i> Salary</h6>
                            <p>{{ $job->formatted_salary }}</p>
                        </div>
                        @if($job->application_deadline)
                            <div class="col-md-6">
                                <h6><i class="bi bi-calendar-event"></i> Application Deadline</h6>
                                <p>{{ $job->application_deadline->format('M d, Y') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Job Description -->
                    <div class="mb-4">
                        <h5>Job Description</h5>
                        <div class="border-start border-primary ps-3">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                    
                    <!-- Requirements -->
                    @if($job->requirements)
                        <div class="mb-4">
                            <h5>Requirements</h5>
                            <div class="border-start border-warning ps-3">
                                {!! nl2br(e($job->requirements)) !!}
                            </div>
                        </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Jobs
                        </a>
                        
                        @auth
                            @if(!$hasApplied)
                                <a href="{{ route('applications.create', $job) }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-plus"></i> Apply for this Position
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection