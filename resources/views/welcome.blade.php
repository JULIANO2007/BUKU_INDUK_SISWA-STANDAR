<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="icon" href="/images/tut wuri handayani.ico">
    <title>SMKN 10 Portal Buku Induk</title>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <img src="/images/smkn.png" alt="SMKN 10 Logo" class="logo">
            <h2>SMKN 10 Portal Buku Induk</h2>
        </header>

        <!-- Split Layout -->
        <div class="split-container">
            <!-- Left Side: Illustrations -->
            <div class="left-panel">
                <div class="illustration">
                    <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="edu-svg">
                        <!-- Student -->
                        <circle cx="200" cy="150" r="30" fill="#A7C7E7"/>
                        <rect x="185" y="180" width="30" height="50" fill="#A7C7E7"/>
                        <!-- Book -->
                        <rect x="150" y="250" width="40" height="30" fill="#FFD3B6"/>
                        <rect x="155" y="255" width="30" height="20" fill="#ffffff"/>
                        <!-- Laptop -->
                        <rect x="220" y="240" width="60" height="40" fill="#F5F7FA" stroke="#A7C7E7"/>
                        <rect x="230" y="250" width="40" height="20" fill="#A7C7E7"/>
                        <!-- Blackboard -->
                        <rect x="100" y="300" width="80" height="50" fill="#A8E6CF"/>
                        <rect x="110" y="310" width="60" height="30" fill="#ffffff"/>
                        <!-- Decorative elements -->
                        <circle cx="50" cy="50" r="20" fill="#FFD3B6" opacity="0.5"/>
                        <circle cx="350" cy="350" r="25" fill="#A8E6CF" opacity="0.3"/>
                    </svg>
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="right-panel">
                <div class="login-card">
                    <h1>Masuk ke Buku Induk</h1>
                    <p class="subtitle">Gunakan akun sekolah Anda untuk mengakses data siswa.</p>

                    @if (session()->has('auth_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('auth_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="/" method="POST" class="login-form" id="loginForm">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email / Nomor Induk" required>
                            <span class="input-icon email-icon"></span>
                        </div>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
                            <span class="input-icon password-icon"></span>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <span class="eye-icon"></span>
                            </button>
                        </div>
                        <a href="#" class="forgot-password">Lupa kata sandi?</a>
                        <button type="submit" class="btn btn-primary" id="loginBtn">
                            <span class="btn-text">Masuk</span>
                            <div class="spinner"></div>
                        </button>
                    </form>

                    <div class="copyright">© 2025 SMKN 10 – Portal Buku Induk</div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/login.js"></script>
</body>
</html>
