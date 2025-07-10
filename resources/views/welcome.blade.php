<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EACC Jobs Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e1e;
            color: #f1f1f1;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar, .footer {
            background-color: #2d2d2d;
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #dcdcdc;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffffff;
        }

        .btn-primary {
            background-color: #006aff;
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056cc;
        }

        .hero {
            padding: 6rem 2rem;
            background: #2c2c2c;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.06);
            animation: fadeIn 1s ease-in-out;
            min-height: 75vh; /* Ensure welcome section is tall */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .highlight {
            color: #bfa77a;
        }

        .footer {
            border-top: 1px solid #444;
        }

        .text-muted {
            color: #aaaaaa !important;
        }

        a {
            text-decoration: none;
        }

        .container-xl {
            max-width: 1140px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-xl">
            <a class="navbar-brand" href="#"><span class="highlight">EACC Portal</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-xl text-center mt-5">
        <div class="hero">
            <h1 class="display-5 mb-3">Welcome to <span class="highlight">EACC Jobs Portal</span></h1>
            <p class="lead">Browse and apply for open positions at the Ethics and Anti-Corruption Commission.</p>
         @auth
    <a href="{{ url('/jobs') }}" class="btn btn-primary btn-lg mt-4">View Available Jobs</a>
@endauth

@guest
    <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4">View Jobs</a>
@endguest

        </div>
    </main>

    <footer class="footer text-center text-muted mt-5 py-3">
        <div class="container-xl">
            &copy; {{ date('Y') }} EACC Jobs Portal. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
