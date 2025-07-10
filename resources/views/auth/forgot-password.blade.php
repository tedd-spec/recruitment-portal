<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - EACC Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #2e2b2b;
            color: #f5f5dc;
            font-family: 'Segoe UI', sans-serif;
        }

        .forgot-card {
            background-color: #3e3b3b;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
            max-width: 450px;
            margin: auto;
            margin-top: 4rem;
        }

        .form-control {
            background-color: #2e2b2b;
            color: #f5f5dc;
            border: 1px solid #777;
        }

        .form-control:focus {
            background-color: #2e2b2b;
            color: #f5f5dc;
            border-color: #bfa77a;
            box-shadow: 0 0 0 0.2rem rgba(191, 167, 122, 0.25);
        }

        .btn-submit {
            background-color: #bfa77a;
            border: none;
            font-size: 0.9rem;
            padding: 0.4rem 1.2rem;
        }

        .btn-submit:hover {
            background-color: #a8976f;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-header .logo-circle {
            width: 80px;
            height: 80px;
            background-color: #bfa77a;
            border-radius: 50%;
            margin: auto;
            margin-bottom: 0.6rem;
        }

        .auth-header h5 {
            color: #f5f5dc;
            margin-top: 0.5rem;
        }

        .info-text {
            font-size: 0.95rem;
            margin-bottom: 1.2rem;
            color: #d4c8a0;
            text-align: center;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #bfa77a;
        }

        .input-group .form-control {
            padding-left: 2.5rem;
        }
    </style>
</head>
<body>

<div class="forgot-card">
    <div class="auth-header">
        <div class="logo-circle"></div>
        <h5>EACC Portal</h5>
    </div>

    <p class="info-text">
        Forgot your password? No problem. Enter your email address below and we’ll email you a password reset link.
    </p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3 position-relative input-group">
            <span class="input-icon"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" required autofocus>
        </div>

        @error('email')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-submit">Send Reset Link</button>
        </div>
    </form>
</div>

</body>
</html>
