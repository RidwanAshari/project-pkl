<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AssetFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-body: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --sidebar-bg: #1f2937;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* SPLIT SCREEN LAYOUT */
        .split-screen {
            display: flex;
            width: 100%;
            height: 100%;
        }

        /* LEFT PANEL (BRANDING) */
        .left-panel {
            width: 50%;
            background: linear-gradient(135deg, var(--sidebar-bg) 0%, #111827 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }

        .bg-pattern {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(#374151 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.2;
            z-index: 0;
        }

        .brand-content { z-index: 1; text-align: center; }
        
        /* LOGO STYLE (SAMA KAYA DATA ASET) */
        .logo-icon { 
            width: 60px; height: 60px; background: var(--primary); 
            border-radius: 8px; display: grid; place-items: center; 
            font-weight: bold; font-size: 2rem; margin: 0 auto 1.5rem auto;
        }
        .logo-text { font-size: 2.5rem; font-weight: 700; letter-spacing: -0.025em; }

        .brand-desc { font-size: 1.1rem; opacity: 0.8; max-width: 80%; line-height: 1.6; margin-top: 1rem; }

        /* RIGHT PANEL (FORM) */
        .right-panel {
            width: 50%;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            position: relative;
        }

        .form-container { width: 100%; max-width: 400px; }
        
        /* MOBILE LOGO (Only visible on small screens) */
        .mobile-logo { display: none; text-align: center; margin-bottom: 2rem; }
        .mobile-logo .logo-icon { width: 50px; height: 50px; font-size: 1.5rem; }
        .mobile-logo .logo-text { font-size: 2rem; }

        .form-header { margin-bottom: 2rem; text-align: center; }
        .form-header h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main); }
        .form-header p { color: var(--text-muted); font-size: 0.95rem; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }
        .form-input {
            width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border);
            border-radius: 8px; outline: none; transition: 0.2s; font-size: 0.95rem;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px #e0e7ff; }
        .form-input::placeholder { color: #9ca3af; }

        .btn-action {
            width: 100%; background: var(--primary); color: white; padding: 0.75rem;
            border-radius: 8px; border: none; font-weight: 600; font-size: 1rem;
            cursor: pointer; transition: 0.2s;
        }
        .btn-action:hover { background: var(--primary-hover); }

        .text-center { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted); }
        .link { color: var(--primary); text-decoration: none; font-weight: 600; cursor: pointer; }
        .link:hover { text-decoration: underline; }

        .forgot-link { display: block; text-align: right; margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-muted); text-decoration: none; }
        .forgot-link:hover { color: var(--primary); }

        .error-msg {
            background: #fef2f2; color: #991b1b; padding: 10px 15px;
            border-radius: 8px; font-size: 0.9rem; margin-bottom: 1.5rem;
            display: none; border: 1px solid #fee2e2; text-align: center;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 2rem; }
            .mobile-logo { display: block; }
            .split-screen { flex-direction: column; }
        }
    </style>
</head>
<body>

    <div class="split-screen">
        
        <!-- KIRI: BRANDING & LOGO (SAMA KAYA DATA ASET) -->
        <div class="left-panel">
            <div class="bg-pattern"></div>
            <div class="brand-content">
                <!-- LOGO -->
                <div class="logo-icon">A</div>
                <!-- NAMA -->
                <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
                
                <p class="brand-desc">Sistem manajemen inventaris modern untuk memantau aset perusahaan Anda secara real-time.</p>
            </div>
        </div>

        <!-- KANAN: FORM SIGN IN / SIGN UP -->
        <div class="right-panel">
            
            <!-- Mobile Logo -->
            <div class="mobile-logo">
                <div class="logo-icon">A</div>
                <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
            </div>

            <div class="form-container">
                
                <div class="form-header">
                    <h2 id="pageTitle">Selamat Datang</h2>
                    <p id="pageDesc">Silakan masuk untuk mengelola aset.</p>
                </div>

                <div id="errorMsg" class="error-msg">Login gagal!</div>

                <!-- FORM 1: SIGN IN -->
                <form id="form-signin" onsubmit="handleLogin(event)">
                    <div class="form-group">
                        <label class="form-label">Email atau Username</label>
                        <input type="text" id="loginId" class="form-input" placeholder="admin@asset.com atau admin" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" id="loginPass" class="form-input" placeholder="•••••••" required>
                        <a href="#" class="forgot-link" onclick="alert('Fitur Lupa Password belum aktif. Hubungi Admin.')">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn-action">Masuk (Sign In)</button>

                    <div class="text-center">
                        Belum punya akun? <span class="link" onclick="toggleForm('signup')">Daftar Sekarang (Sign Up)</span>
                    </div>
                </form>

                <!-- FORM 2: SIGN UP (AWALNYA HIDDEN) -->
                <form id="form-signup" style="display: none;" onsubmit="handleSignup(event)">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" id="regName" class="form-input" placeholder="Budi Santoso" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="regEmail" class="form-input" placeholder="budi@example.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" id="regPass" class="form-input" placeholder="Buat password kuat" required>
                    </div>

                    <button type="submit" class="btn-action">Daftar Akun (Sign Up)</button>

                    <div class="text-center">
                        Sudah punya akun? <span class="link" onclick="toggleForm('signin')">Masuk Sekarang (Sign In)</span>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        // Fungsi Pindah Form (Sign In <-> Sign Up)
        function toggleForm(type) {
            const formSignin = document.getElementById('form-signin');
            const formSignup = document.getElementById('form-signup');
            const title = document.getElementById('pageTitle');
            const desc = document.getElementById('pageDesc');
            const error = document.getElementById('errorMsg');

            error.style.display = 'none'; // Hilangkan error

            if (type === 'signup') {
                formSignin.style.display = 'none';
                formSignup.style.display = 'block';
                title.innerText = 'Buat Akun Baru';
                desc.innerText = 'Daftar untuk mulai menggunakan AssetFlow.';
            } else {
                formSignup.style.display = 'none';
                formSignin.style.display = 'block';
                title.innerText = 'Selamat Datang';
                desc.innerText = 'Silakan masuk untuk mengelola aset.';
            }
        }

        // Logika LOGIN
        function handleLogin(e) {
            e.preventDefault();
            const loginId = document.getElementById('loginId').value;
            const password = document.getElementById('loginPass').value;
            const errorBox = document.getElementById('errorMsg');

            // LOGIKA DUMMY (Bisa pakai admin ATAU admin@asset.com)
            if ((loginId === 'admin' || loginId === 'admin@asset.com') && password === 'password') {
                localStorage.setItem('isLoggedIn', 'true');
                window.location.href = '/';
            } else {
                errorBox.style.display = 'block';
                errorBox.innerText = 'Email/Username atau Password salah!';
            }
        }

        // Logika SIGN UP
        function handleSignup(e) {
            e.preventDefault();
            const name = document.getElementById('regName').value;
            const email = document.getElementById('regEmail').value;
            const pass = document.getElementById('regPass').value;

            // Simulasi Daftar
            alert(`Akun atas nama ${name} (${email}) berhasil dibuat! Silakan login.`);
            
            // Kembali ke halaman login otomatis
            toggleForm('signin');
        }
    </script>
</body>
</html>