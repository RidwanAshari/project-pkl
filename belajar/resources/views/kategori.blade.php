<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Aset</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4f46e5; --bg-body: #f3f4f6; --bg-card: #ffffff; --text-main: #111827; --border: #e5e7eb; --radius: 12px; }
        body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 260px; background: #1f2937; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo-area { padding: 2rem 1.5rem; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid #374151; }
        .nav-menu { padding: 1.5rem 1rem; list-style: none; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #9ca3af; text-decoration: none; border-radius: 8px; margin-bottom: 4px; font-weight: 500; }
        .nav-item a:hover, .nav-item a.active { background-color: #374151; color: white; }
        .nav-item a.active { background-color: var(--primary); }

        .main-content { flex: 1; overflow-y: auto; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        
        .grid-cat { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; }
        .cat-card { background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid var(--border); text-align: center; transition: 0.2s; }
        .cat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .cat-icon { font-size: 3rem; margin-bottom: 1rem; display: inline-block; }
        .cat-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; }
        .cat-count { font-size: 2rem; font-weight: 800; color: var(--primary); }
        .cat-label { color: var(--text-muted); font-size: 0.9rem; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="logo-area">📦 AssetFlow</div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="/">🏠 Dashboard</a></li>
            <li class="nav-item"><a href="/data-aset">📊 Data Aset</a></li>
            <li class="nav-item"><a href="/history">📅 History Peminjaman</a></li>
            <li class="nav-item"><a href="/kategori" class="active">📂 Kategori</a></li>
        </ul>
    </nav>

    <!-- KONTEN -->
    <main class="main-content">
        <div class="header">
            <div>
                <h1 style="margin:0; font-size:1.5rem;">Kategori Barang</h1>
                <p style="margin:5px 0 0 0; color:var(--text-muted);">Pengelompokan aset berdasarkan jenis.</p>
            </div>
        </div>

        <div class="grid-cat">
            <div class="cat-card">
                <div class="cat-icon">💻</div>
                <div class="cat-title">Elektronik</div>
                <div class="cat-count">142</div>
                <div class="cat-label">Total Barang</div>
            </div>

            <div class="cat-card">
                <div class="cat-icon">🪑</div>
                <div class="cat-title">Furniture</div>
                <div class="cat-count">85</div>
                <div class="cat-label">Total Barang</div>
            </div>

            <div class="cat-card">
                <div class="cat-icon">🚚</div>
                <div class="cat-title">Kendaraan</div>
                <div class="cat-count">24</div>
                <div class="cat-label">Total Barang</div>
            </div>

            <div class="cat-card">
                <div class="cat-icon">🔧</div>
                <div class="cat-title">Alat Berat</div>
                <div class="cat-count">12</div>
                <div class="cat-label">Total Barang</div>
            </div>
            
            <div class="cat-card" style="background: #f9fafb; border-style: dashed; display: grid; place-items: center; cursor: pointer;">
                <div style="font-size:2rem; color:var(--text-muted);">+</div>
                <div style="margin-top:0.5rem; font-weight:600;">Tambah Kategori</div>
            </div>
        </div>
    </main>

</body>
</html>