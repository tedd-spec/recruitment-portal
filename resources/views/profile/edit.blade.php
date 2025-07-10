@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-1">Profile Settings</h1>
            <p class="text-muted">Manage your account settings and preferences</p>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>Profile updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-shield-check me-2"></i>Password updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('status') === 'profile-picture-removed')
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-image me-2"></i>Profile picture removed successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person me-2"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Profile Picture Section -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $user->profile_picture_url }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle border border-3 border-primary"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                    
                                    @if($user->profile_picture)
                                        <form method="POST" action="{{ route('profile.remove-picture') }}" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle" 
                                                    style="width: 30px; height: 30px;" 
                                                    onclick="return confirm('Remove profile picture?')">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                
                                <div class="mt-3">
                                    <label for="profile_picture" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-camera me-1"></i>Change Photo
                                    </label>
                                    <input type="file" id="profile_picture" name="profile_picture" 
                                           class="d-none" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text">JPG, PNG, GIF up to 2MB</div>
                                    @error('profile_picture')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div class="form-text text-warning">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Your email address is unverified.
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Account Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-graph-up me-2"></i>Account Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $user->applications()->count() ?? 0 }}</h4>
                                <small class="text-muted">Applications</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $user->created_at->format('M Y') }}</h4>
                            <small class="text-muted">Member Since</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-lightning me-2"></i>Explore 
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-briefcase me-1"></i>Browse Jobs
                        </a>
                        <a href="{{ route('applications.my-applications') }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-file-text me-1"></i>My Applications
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-house me-1"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Section -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock me-2"></i>Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-key me-1"></i>Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Account Section -->
        <div class="col-lg-6 mb-4">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="text-danger">Delete Account</h6>
                    <p class="text-muted small">
                        Once your account is deleted, all of its resources and data will be permanently deleted. 
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash me-1"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Warning!</strong> This action cannot be undone. This will permanently delete your account and all associated data.
                    </div>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Confirm your password to continue:</label>
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                               id="delete_password" name="password" required 
                               placeholder="Enter your current password">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Yes, Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = input.closest('.row').querySelector('img');
            img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection