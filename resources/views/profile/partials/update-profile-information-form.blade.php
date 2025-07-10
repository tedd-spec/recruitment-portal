<section class="profile-form">
    <form method="post" action="{{ route('profile.update') }}" class="form-content">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">
                <i class="fas fa-user"></i> Full Name
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Enter your full name"
            />
            @if($errors->get('name'))
                <div class="error-message">
                    @foreach($errors->get('name') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email">
                <i class="fas fa-envelope"></i> Email Address
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username" 
                placeholder="Enter your email address"
            />
            @if($errors->get('email'))
                <div class="error-message">
                    @foreach($errors->get('email') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="verification-alert">
                    <p>
                        <i class="fas fa-exclamation-triangle"></i>
                        Your email address is unverified.
                    </p>
                    
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="verification-btn">
                            Resend Verification Email
                        </button>
                    </form>

                    @if (session('status') === 'verification-link-sent')
                        <p class="verification-sent">
                            <i class="fas fa-check-circle"></i>
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <div class="success-message"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 3000)">
                    <i class="fas fa-check-circle"></i> Profile updated successfully!
                </div>
            @endif
        </div>
    </form>
</section>

<style>
.profile-form {
    color: #2a2e35;
}

.form-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 0.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #2a2e35;
}

.form-group label i {
    color: #d4af37;
    margin-right: 0.5rem;
}

.form-group input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d2b48c;
    border-radius: 8px;
    background-color: #f8f5eb;
    color: #2a2e35;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: #d4af37;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    outline: none;
}

.form-group input::placeholder {
    color: #a0a0a0;
}

.error-message {
    margin-top: 0.5rem;
    color: #9e2a2b;
    font-size: 0.85rem;
}

.verification-alert {
    margin-top: 1rem;
    padding: 1rem;
    background-color: rgba(212, 175, 55, 0.1);
    border-left: 4px solid #d4af37;
    border-radius: 4px;
}

.verification-alert p {
    color: #2a2e35;
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.verification-alert i {
    color: #d4af37;
    margin-right: 0.5rem;
}

.verification-btn {
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.verification-btn:hover {
    background: linear-gradient(135deg, #b8941f 0%, #a37e1a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(184, 148, 31, 0.3);
}

.verification-sent {
    margin-top: 0.75rem;
    color: #28a745;
    font-size: 0.85rem;
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(210, 180, 140, 0.3);
}

.success-message {
    display: inline-flex;
    align-items: center;
    background-color: rgba(40, 167, 69, 0.1);
    border: 1px solid rgba(40, 167, 69, 0.2);
    color: #28a745;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.9rem;
}

.success-message i {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .success-message {
        margin-top: 1rem;
    }
}
</style>
