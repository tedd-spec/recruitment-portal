<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - EACC Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #121212;
            color: #f5f5dc;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background-color: #1f1f1f;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
            max-width: 400px;
            margin: auto;
            margin-top: 4rem;
        }

        .form-control {
            background-color: #2c2c2c;
            color: #f5f5dc;
            border: 1px solid #666;
        }

        .form-control:focus {
            background-color: #2c2c2c;
            color: #f5f5dc;
            border-color: #bfa77a;
            box-shadow: 0 0 0 0.2rem rgba(191, 167, 122, 0.25);
        }

        .btn-login {
            background-color: #bfa77a;
            color: #121212;
            border: none;
            font-size: 0.9rem;
            padding: 0.45rem 1.3rem;
        }

        .btn-login:hover {
            background-color: #a8976f;
        }

        .form-label, .form-check-label {
            color: #d4c8a0;
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

        a {
            color: #d4c8a0;
            text-decoration: none;
        }

        a:hover {
            color: #cbbd85;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="auth-header">
        <div class="logo-circle"></div>
        <h5>EACC Portal</h5>
    </div>

    @if (session('status'))
        <div class="alert alert-info text-center small py-2">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3 position-relative input-group">
            <span class="input-icon"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        </div>

        <div class="mb-3 position-relative input-group">
            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember_me">
            <label for="remember_me" class="form-check-label">Remember me</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
            @endif

            <button type="submit" class="btn btn-login">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</div>

</body>
</html>
