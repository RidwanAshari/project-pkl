<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDAM Asset Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #0066cc;
            --primary-dark: #0052a3;
            --water-blue: #00b4d8;
            --light-blue: #caf0f8;
            --white: #ffffff;
            --gray-light: #f8f9fa;
            --gray: #6c757d;
            --gray-dark: #343a40;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --shadow: 0 10px 30px rgba(0, 102, 204, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, var(--light-blue) 0%, #e6f7ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 550px;
            background: var(--white);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow);
            animation: slideIn 0.6s ease-out;
        }
        
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-30px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }
        
        /* Left Panel - Logo & Info */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--water-blue) 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .logo-section {
            position: relative;
            z-index: 2;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 2rem;
        }
        
        .logo-icon {
            width: 70px;
            height: 70px;
            background: var(--white);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-size: 32px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .logo-text h1 {
            font-weight: 800;
            margin: 0;
            font-size: 2rem;
            line-height: 1.2;
        }
        
        .logo-text p {
            margin: 0;
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .welcome-section {
            margin-top: auto;
            position: relative;
            z-index: 2;
        }
        
        .welcome-section h2 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }
        
        .welcome-section p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.9;
            max-width: 350px;
        }
        
        .water-drop {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            font-size: 80px;
            z-index: 1;
        }
        
        .water-drop-1 { top: 20%; left: 10%; }
        .water-drop-2 { bottom: 30%; right: 20%; }
        
        /* Right Panel - Login Form */
        .right-panel {
            flex: 1.2;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .form-header h2 {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .form-header p {
            color: var(--gray);
            font-size: 1rem;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 204, 0.25);
        }
        
        .input-group {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .input-group-text {
            background-color: var(--gray-light);
            border: 2px solid #e0e0e0;
            border-right: none;
            color: var(--gray);
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .input-group .btn-toggle-password {
            background-color: var(--gray-light);
            border: 2px solid #e0e0e0;
            border-left: none;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .input-group .btn-toggle-password:hover {
            background-color: #e9ecef;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 0.875rem;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: all 0.3s;
            width: 100%;
            color: white;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .form-check-label {
            color: var(--gray-dark);
            font-weight: 500;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--gray-dark);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .forgot-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        
        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .register-link {
            color: var(--gray);
            font-size: 0.95rem;
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .register-link a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }
        
        .demo-accounts {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .demo-accounts .btn {
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        .copyright {
            text-align: center;
            color: var(--gray);
            font-size: 0.85rem;
            margin-top: 2rem;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
                min-height: auto;
            }
            
            .left-panel {
                padding: 2rem;
            }
            
            .right-panel {
                padding: 2rem;
            }
            
            .logo-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }
            
            .logo-text h1 {
                font-size: 1.8rem;
            }
            
            .welcome-section h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .login-container {
                border-radius: 20px;
            }
            
            .left-panel,
            .right-panel {
                padding: 1.5rem;
            }
            
            .logo {
                gap: 12px;
            }
            
            .logo-icon {
                width: 50px;
                height: 50px;
                font-size: 24px;
                border-radius: 12px;
            }
            
            .logo-text h1 {
                font-size: 1.5rem;
            }
            
            .form-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel - Logo & Welcome -->
        <div class="left-panel">
            <div class="water-drop water-drop-1">
                <i class="fas fa-tint"></i>
            </div>
            <div class="water-drop water-drop-2">
                <i class="fas fa-tint"></i>
            </div>
            
            <div class="logo-section">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div class="logo-text">
                        <h1>PDAM INV</h1>
                        <p>Asset Management System</p>
                    </div>
                </div>
                
                <div class="welcome-section">
                    <h2>Selamat Datang</h2>
                    <p>Sistem manajemen aset terpadu untuk mengelola inventaris perusahaan dengan efisien dan terstruktur.</p>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Login Form -->
        <div class="right-panel">
            <div class="form-header">
                <h2>Login ke Akun Anda</h2>
                <p>Masuk ke Dashboard Sistem</p>
            </div>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3" style="list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="email" type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email" 
                               autofocus
                               placeholder="email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Masukkan kata sandi">
                        <button class="btn btn-toggle-password" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>
                
                <!-- Submit Button -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-login btn-lg" id="submitBtn">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>
                </div>
                
                <!-- Demo Credentials (for development only) -->
                @if (app()->environment('local'))
                    <div class="demo-accounts">
                        <small class="text-muted d-block mb-2">Akun Demo:</small>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-primary" onclick="fillDemo('nabe@sample.com', 'carlossainz')">
                                <i class="fas fa-user-shield me-1"></i> Admin
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick="fillDemo('admin@example.com', 'password123')">
                                <i class="fas fa-user-tie me-1"></i> Manager
                            </button>
                            <button type="button" class="btn btn-outline-info" onclick="fillDemo('user@example.com', 'password123')">
                                <i class="fas fa-user me-1"></i> Staff
                            </button>
                        </div>
                    </div>
                @endif
                
                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="register-link">
                        Belum punya akun? 
                        <a href="{{ route('register') }}">Daftar disini</a>
                    </div>
                @endif
            </form>
            
            <!-- Copyright -->
            <div class="copyright">
                &copy; 2024 PDAM - Sistem Manajemen Aset. All rights reserved.
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Auto-fill demo credentials
        function fillDemo(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            
            // Show notification
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-info alert-dismissible fade show mb-4';
            alertDiv.innerHTML = `
                <i class="fas fa-info-circle me-2"></i> 
                Akun demo telah diisi! Klik "Masuk" untuk melanjutkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const form = document.getElementById('loginForm');
            const firstChild = form.querySelector('.alert-danger, .alert-success, .mb-4');
            if (firstChild) {
                form.insertBefore(alertDiv, firstChild.nextSibling);
            } else {
                form.prepend(alertDiv);
            }
            
            // Auto-dismiss after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }
            }, 3000);
        }
        
        // Auto-focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                setTimeout(() => emailField.focus(), 300);
            }
        });
        
        // Handle Enter key to submit form
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.target.matches('textarea, [type="button"], [type="submit"]')) {
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.click();
                }
            }
        });
        
        // Show loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                submitBtn.disabled = true;
                
                // Re-enable button after 5 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i> Masuk';
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
        
        // Add subtle animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.form-control, .btn');
            formElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>