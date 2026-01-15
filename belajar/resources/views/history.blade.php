<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Peminjaman</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4f46e5; --bg-body: #f3f4f6; --bg-card: #ffffff; --text-main: #111827; --text-muted: #6b7280; --border: #e5e7eb; --success: #10b981; --warning: #f59e0b; --radius: 12px; }
        body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 260px; background: #1f2937; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo-area { padding: 2rem 1.5rem; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid #374151; }
        .nav-menu { padding: 1.5rem 1rem; list-style: none; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #9ca3af; text-decoration: none; border-radius: 8px; margin-bottom: 4px; font-weight: 500; }
        .nav-item a:hover, .nav-item a.active { background-color: #374151; color: white; }
        .nav-item a.active { background-color: var(--primary); }

        .main-content { flex: 1; overflow-y: auto; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .card { background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid var(--border); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f9fafb; padding: 1rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); }
        td { padding: 1rem; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-kembali { background: #d1fae5; color: #065f46; }
        .badge-pakai { background: #ffedd5; color: #9a3412; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="logo-area">📦 AssetFlow</div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="/dashboard">🏠 Dashboard</a></li>
            <li class="nav-item"><a href="/data-aset">📊 Data Aset</a></li>
            <li class="nav-item"><a href="/history" class="active">📅 History Peminjaman</a></li>
            <li class="nav-item"><a href="/kategori">📂 Kategori</a></li>
        </ul>
    </nav>

    <!-- KONTEN -->
    <main class="main-content">
        <div class="header">
            <div>
                <h1 style="margin:0; font-size:1.5rem;">Riwayat Peminjaman</h1>
                <p style="margin:5px 0 0 0; color:var(--text-muted);">Log peminjaman dan pengembalian barang.</p>
            </div>
            <button style="padding:10px 20px; background:var(--primary); color:white; border:none; border-radius:8px; cursor:pointer;">+ Pinjam Barang</button>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Barang Aset</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Dummy History -->
                    <tr>
                        <td>Budi Santoso</td>
                        <td>MacBook Pro M2 (AST-001)</td>
                        <td>23 Okt 2023</td>
                        <td>25 Okt 2023</td>
                        <td><span class="badge badge-pakai">Dipakai</span></td>
                    </tr>
                    <tr>
                        <td>Andi Pratama</td>
                        <td>Proyector Epson (AST-012)</td>
                        <td>20 Okt 2023</td>
                        <td>21 Okt 2023</td>
                        <td><span class="badge badge-kembali">Dikembalikan</span></td>
                    </tr>
                    <tr>
                        <td>Siti Aminah</td>
                        <td>Kursi Kantor Lipat (AST-045)</td>
                        <td>10 Okt 2023</td>
                        <td>12 Okt 2023</td>
                        <td><span class="badge badge-kembali">Dikembalikan</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>