<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Sistem Manajemen Aset PDAM</title>
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
            overflow-x: hidden;
        }

        .register-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side - Branding */
        .register-left {
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

        .register-left::before {
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

        .benefits {
            margin-top: 50px;
            max-width: 450px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .benefit-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .benefit-content h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .benefit-content p {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }

        /* Right Side - Register Form */
        .register-right {
            flex: 1.2;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px;
            overflow-y: auto;
        }

        .register-container {
            width: 100%;
            max-width: 600px;
            padding: 20px 0;
        }

        .register-header {
            margin-bottom: 35px;
        }

        .register-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .register-header p {
            font-size: 16px;
            color: #666;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-danger ul {
            margin: 10px 0 0 20px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group label .required {
            color: #e74c3c;
            margin-left: 3px;
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

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            background: #fafafa;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath fill='%23999' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 24px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid,
        .form-group select.is-invalid {
            border-color: #e74c3c;
            background: #fff5f5;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 8px;
            display: block;
        }

        .password-hint {
            font-size: 12px;
            color: #999;
            margin-top: 8px;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #666;
            margin-bottom: 0;
            cursor: pointer;
            line-height: 1.5;
        }

        .checkbox-group label a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .checkbox-group label a:hover {
            text-decoration: underline;
        }

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-register:active {
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

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .login-link p {
            color: #666;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #5b6fd8;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .register-left {
                display: none;
            }

            .register-right {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            .register-right {
                padding: 30px 20px;
            }

            .register-header h2 {
                font-size: 26px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <!-- Left Side - Branding -->
        <div class="register-left">
            <div class="branding">
                <div class="branding-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </div>
                <h1>Bergabung dengan Kami</h1>
                <p>Mulai kelola aset perusahaan Anda dengan lebih efisien</p>
            </div>

            <div class="benefits">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <div class="benefit-content">
                        <h3>Manajemen Terpusat</h3>
                        <p>Kelola semua aset perusahaan dalam satu platform terintegrasi</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="benefit-content">
                        <h3>Tracking Real-time</h3>
                        <p>Pantau kondisi dan lokasi aset secara real-time kapan saja</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <div class="benefit-content">
                        <h3>Laporan Lengkap</h3>
                        <p>Generate laporan komprehensif untuk analisis dan audit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-right">
            <div class="register-container">
                <div class="register-header">
                    <h2>Daftar Akun Baru</h2>
                    <p>Isi formulir di bawah untuk membuat akun Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terdapat beberapa kesalahan:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Personal Information -->
                    <div class="form-section">
                        <div class="form-section-title">Informasi Pribadi</div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">Nama Depan <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="text" 
                                           id="first_name" 
                                           name="first_name" 
                                           class="@error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name') }}"
                                           placeholder="Nama depan" 
                                           required>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">Nama Belakang <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="text" 
                                           id="last_name" 
                                           name="last_name" 
                                           class="@error('last_name') is-invalid @enderror"
                                           value="{{ old('last_name') }}"
                                           placeholder="Nama belakang" 
                                           required>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="@error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="nama@email.com" 
                                           required>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Nomor Telepon <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           class="@error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="08xxxxxxxxxx" 
                                           required>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Work Information -->
                    <div class="form-section">
                        <div class="form-section-title">Informasi Pekerjaan</div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="position">Jabatan <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <select id="position" 
                                            name="position" 
                                            class="@error('position') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih Jabatan</option>
                                        <option value="admin" {{ old('position') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="staff" {{ old('position') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="manager" {{ old('position') == 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="supervisor" {{ old('position') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                        <option value="operator" {{ old('position') == 'operator' ? 'selected' : '' }}>Operator</option>
                                    </select>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('position')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="department">Departemen <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <select id="department" 
                                            name="department" 
                                            class="@error('department') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih Departemen</option>
                                        <option value="it" {{ old('department') == 'it' ? 'selected' : '' }}>IT & Teknologi</option>
                                        <option value="finance" {{ old('department') == 'finance' ? 'selected' : '' }}>Keuangan</option>
                                        <option value="operations" {{ old('department') == 'operations' ? 'selected' : '' }}>Operasional</option>
                                        <option value="maintenance" {{ old('department') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
                                        <option value="admin" {{ old('department') == 'admin' ? 'selected' : '' }}>Administrasi</option>
                                        <option value="hr" {{ old('department') == 'hr' ? 'selected' : '' }}>SDM</option>
                                    </select>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('department')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="form-section">
                        <div class="form-section-title">Informasi Akun</div>
                        
                        <div class="form-group">
                            <label for="username">Username <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       id="username" 
                                       name="username" 
                                       class="@error('username') is-invalid @enderror"
                                       value="{{ old('username') }}"
                                       placeholder="Username untuk login" 
                                       required>
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="password-hint">Minimal 5 karakter, hanya huruf dan angka</div>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="@error('password') is-invalid @enderror"
                                           placeholder="Buat password" 
                                           required>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="password-hint">Minimal 8 karakter</div>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Ulangi password" 
                                           required>
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               class="@error('terms') is-invalid @enderror"
                               required>
                        <label for="terms">
                            Saya setuju dengan <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> yang berlaku
                        </label>
                    </div>
                    @error('terms')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn-register">Daftar Sekarang</button>
                </form>

                <div class="divider">
                    <span>Sudah punya akun?</span>
                </div>

                <div class="login-link">
                    <p>Masuk ke akun yang sudah ada</p>
                    <a href="{{ route('login') }}">← Kembali ke Halaman Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>