<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Manajemen Aset Kantor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 3rem;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4e73df;
            margin-bottom: 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        .features-list {
            list-style: none;
            padding-left: 0;
        }
        
        .features-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .features-list li:last-child {
            border-bottom: none;
        }
        
        .features-list i {
            color: #4e73df;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-card">
            <div class="text-center mb-4">
                <div class="logo">
                    <i class="fas fa-cubes"></i> Asset Manager
                </div>
                <p class="text-muted">Sistem Manajemen Aset Kantor Terintegrasi</p>
            </div>
            
            <h3 class="text-center mb-4">Selamat Datang</h3>
            
            <div class="mb-4">
                <h6 class="mb-3">Fitur Utama:</h6>
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Manajemen Aset Digital</li>
                    <li><i class="fas fa-check-circle"></i> QR Code & Barcode</li>
                    <li><i class="fas fa-check-circle"></i> Pelacakan Pemegang Aset</li>
                    <li><i class="fas fa-check-circle"></i> Laporan & Analisis</li>
                    <li><i class="fas fa-check-circle"></i> Berita Acara Otomatis</li>
                </ul>
            </div>
            
            <div class="d-grid gap-2">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Sistem
                </a>
                
                @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                    <i class="fas fa-user-plus me-2"></i> Buat Akun Baru
                </a>
                @endif
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        &copy; {{ date('Y') }} Sistem Manajemen Aset
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>