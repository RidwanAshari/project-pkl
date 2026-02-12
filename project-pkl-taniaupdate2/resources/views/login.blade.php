<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Manajemen Aset PDAM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Left Side - Branding */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #5b6fd8 0%, #667eea 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveGrid 20s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .branding {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .branding-icon {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .branding-icon svg {
            width: 70px;
            height: 70px;
            fill: #5b6fd8;
        }

        .branding h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .branding p {
            font-size: 20px;
            opacity: 0.95;
            font-weight: 300;
            margin-bottom: 40px;
        }

        .features {
            margin-top: 50px;
            max-width: 400px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .feature-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .feature-text {
            font-size: 15px;
            font-weight: 400;
        }

        /* Right Side - Login Form */
        .login-right {
            flex: 1;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 16px;
            color: #666;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #2c662d;
            border: 1px solid #9ec;
        }

        .alert svg {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
        }

        .input-icon svg {
            width: 100%;
            height: 100%;
            fill: #999;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            background: #fafafa;
        }

        .form-group input:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-group input:focus + .input-icon svg {
            fill: #667eea;
        }

        .form-group input.is-invalid {
            border-color: #e74c3c;
            background: #fff5f5;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }

        .invalid-feedback svg {
            width: 16px;
            height: 16px;
            margin-right: 5px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            user-select: none;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #5b6fd8;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 20px;
            position: relative;
            color: #999;
            font-size: 14px;
            font-weight: 500;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .register-link p {
            color: #666;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #5b6fd8;
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .login-left {
                display: none;
            }

            .login-right {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            .login-right {
                padding: 30px;
            }

            .login-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <div class="branding">
                <div class="branding-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </div>
                <h1>Aset PDAM</h1>
                <p>Sistem Manajemen Aset Kantor</p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Kelola aset perusahaan dengan mudah</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Monitoring real-time kondisi aset</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Laporan lengkap dan terorganisir</div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-container">
                <div class="login-header">
                    <h2>Selamat Datang Kembali</h2>
                    <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <strong>{{ $errors->first() }}</strong>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   class="@error('username') is-invalid @enderror"
                                   value="{{ old('username') }}"
                                   placeholder="Masukkan username Anda" 
                                   required 
                                   autofocus>
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                        @error('username')
                            <span class="invalid-feedback">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="@error('password') is-invalid @enderror"
                                   placeholder="Masukkan password Anda" 
                                   required>
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                        <div class="forgot-password">
                            <a href="#" onclick="alert('Fitur lupa password sedang dalam pengembangan. Silakan hubungi administrator.'); return false;">Lupa Password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">Masuk</button>
                </form>

                <div class="divider">
                    <span>Belum punya akun?</span>
                </div>

                <div class="register-link">
                    <p>Bergabunglah dengan sistem manajemen aset kami</p>
                    <a href="{{ route('register') }}">Daftar Akun Baru →</a>
                </div>

                <div class="footer-text">
                    © 2026 Aset PDAM. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>