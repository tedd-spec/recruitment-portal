@extends('layouts.app')

@section('content')
<div class="container mt-5 text-light">
    <div class="card bg-dark border-light">
        <div class="card-header">
            <h3>Apply for: {{ $job->title }}</h3>
            <div class="progress mt-3" style="height: 8px;">
                <div class="progress-bar progress-bar-striped bg-success" id="formProgress" role="progressbar"
                    style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div class="card-body">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="applicationForm" action="{{ route('applications.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Step 1 --}}
                <div class="form-step active animate__animated animate__fadeIn">
                    <h5>Step 1: Personal Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>First Name *</label>
                            <input type="text" class="form-control" name="first_name" required value="{{ old('first_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label>Last Name *</label>
                            <input type="text" class="form-control" name="last_name" required value="{{ old('last_name') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Email *</label>
                            <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6">
                            <label>Phone Number *</label>
                            <input type="text" class="form-control" name="phone" required value="{{ old('phone') }}">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary next-step float-end">Next</button>
                </div>

                {{-- Step 2 --}}
                <div class="form-step d-none animate__animated">
                    <h5>Step 2: Address & Education</h5>
                    <div class="mb-3">
                        <label>Address *</label>
                        <input type="text" class="form-control" name="address" required value="{{ old('address') }}">
                    </div>
                    <div class="mb-3">
                        <label>Education Level *</label>
                        <select class="form-select" name="education_level" required>
                            <option value="">-- Select your level --</option>
                            <option value="KCSE Certificate">KCSE Certificate</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                            <option value="Master's Degree">Master's Degree</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary prev-step">Back</button>
                    <button type="button" class="btn btn-primary next-step float-end">Next</button>
                </div>

                {{-- Step 3 --}}
                <div class="form-step d-none animate__animated">
                    <h5>Step 3: Experience & Skills</h5>
                    <div class="mb-3">
                        <label>Work Experience *</label>
                        <textarea class="form-control" name="work_experience" rows="3" required>{{ old('work_experience') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Skills & Competencies *</label>
                        <textarea class="form-control" name="skills" rows="3" required>{{ old('skills') }}</textarea>
                    </div>
                    <button type="button" class="btn btn-secondary prev-step">Back</button>
                    <button type="button" class="btn btn-primary next-step float-end">Next</button>
                </div>

                {{-- Step 4 --}}
                <div class="form-step d-none animate__animated">
                    <h5>Step 4: Documents</h5>
                    <div class="mb-3">
                        <label>Resume (PDF/DOC/DOCX, Max 5MB) *</label>
                        <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx" required>
                        <small class="form-text text-light">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</small>
                        @error('resume')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Cover Letter (Optional)</label>
                        <textarea class="form-control" name="cover_letter" rows="4">{{ old('cover_letter') }}</textarea>
                    </div>
                    <button type="button" class="btn btn-secondary prev-step">Back</button>
                    <button type="submit" class="btn btn-success float-end">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Animate.css CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

{{-- Stepper & Animation Script --}}
<script>
     document.getElementById('applicationForm').addEventListener('submit', function(e) {
        if (currentStep !== steps.length - 1) {
            e.preventDefault();
            currentStep = steps.length - 1;
            showStep(currentStep);
            alert('Please finish the final step (Resume Upload) before submitting.');
        }
    });
     document.addEventListener('DOMContentLoaded', function () {
        let currentStep = 0;
        const steps = document.querySelectorAll('.form-step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const progress = document.getElementById('formProgress');

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.add('d-none');
                step.classList.remove('animate__fadeIn');
            });

            steps[index].classList.remove('d-none');
            steps[index].classList.add('animate__fadeIn');

            const percentage = ((index + 1) / steps.length) * 100;
            progress.style.width = percentage + '%';
            progress.setAttribute('aria-valuenow', percentage);
        }

        nextButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        prevButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        showStep(currentStep);
    });
</script>
@endsection
