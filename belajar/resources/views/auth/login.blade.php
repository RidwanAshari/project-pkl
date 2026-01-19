<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AssetFlow</title>

    {{-- Opsional: kalau sering 400 dari Google Fonts, baris ini bisa kamu komentari --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght;400;500;600;700&display=swap" rel="stylesheet"> --}}

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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .split-screen {
            display: flex;
            width: 100%;
            height: 100%;
        }

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

        .logo-icon {
            width: 60px; height: 60px; background: var(--primary);
            border-radius: 8px; display: grid; place-items: center;
            font-weight: bold; font-size: 2rem; margin: 0 auto 1.5rem auto;
        }

        .logo-text { font-size: 2.5rem; font-weight: 700; letter-spacing: -0.025em; }

        .brand-desc {
            font-size: 1.1rem; opacity: 0.8; max-width: 80%;
            line-height: 1.6; margin-top: 1rem;
        }

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

        .mobile-logo {
            display: none;
            text-align: center;
            margin-bottom: 2rem;
        }

        .mobile-logo .logo-icon { width: 50px; height: 50px; font-size: 1.5rem; }
        .mobile-logo .logo-text { font-size: 2rem; }

        .form-header { margin-bottom: 2rem; text-align: center; }
        .form-header h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main); }
        .form-header p { color: var(--text-muted); font-size: 0.95rem; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            transition: 0.2s;
            font-size: 0.95rem;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px #e0e7ff;
        }

        .form-input::placeholder { color: #9ca3af; }

        .btn-action {
            width: 100%;
            background: var(--primary);
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-action:hover { background: var(--primary-hover); }

        .error-msg {
            background: #fef2f2;
            color: #991b1b;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fee2e2;
            text-align: center;
        }

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

    {{-- PANEL KIRI: BRANDING --}}
    <div class="left-panel">
        <div class="bg-pattern"></div>
        <div class="brand-content">
            <div class="logo-icon">A</div>
            <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
            <p class="brand-desc">
                Sistem manajemen inventaris modern untuk memantau aset perusahaan Anda secara real-time.
            </p>
        </div>
    </div>

    {{-- PANEL KANAN: FORM LOGIN --}}
    <div class="right-panel">
        <div class="mobile-logo">
            <div class="logo-icon">A</div>
            <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
        </div>

        <div class="form-container">
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk untuk mengelola aset.</p>
            </div>

            {{-- Pesan error dari backend --}}
            @if ($errors->any())
                <div class="error-msg">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- FORM LOGIN LARAVEL --}}
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="admin@asset.com"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-input"
                        placeholder="•••••••"
                        required
                    >
                </div>

                <button type="submit" class="btn-action">
                    Masuk (Sign In)
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
