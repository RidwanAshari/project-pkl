<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Aset</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4f46e5; --bg-body: #f3f4f6; --bg-card: #ffffff; --text-main: #111827; --text-muted: #6b7280; --border: #e5e7eb; --radius: 12px; }
        body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 260px; background: #1f2937; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo-area { padding: 2rem 1.5rem; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid #374151; display: flex; gap: 10px; align-items: center; }
        .logo-icon { width: 32px; height: 32px; background: var(--primary); border-radius: 8px; display: grid; place-items: center; font-weight: bold; }
        .nav-menu { padding: 1.5rem 1rem; list-style: none; flex: 1; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #9ca3af; text-decoration: none; border-radius: 8px; margin-bottom: 4px; font-weight: 500; transition: 0.2s; }
        .nav-item a:hover, .nav-item a.active { background-color: #374151; color: white; }
        .nav-item a.active { background-color: var(--primary); }

        .main-content { flex: 1; overflow-y: auto; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        
        .grid-cat { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .cat-card { background: var(--bg-card); padding: 2rem; border-radius: var(--radius); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid var(--border); text-align: center; transition: 0.2s; text-decoration: none; color: var(--text-main); display: block; }
        .cat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-color: var(--primary); }
        .cat-icon { font-size: 3.5rem; margin-bottom: 1.5rem; display: inline-block; }
        .cat-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; }
        .cat-desc { color: var(--text-muted); font-size: 0.9rem; }
        .cat-count { margin-top: 1rem; font-size: 0.85rem; background: #e0e7ff; color: var(--primary); padding: 4px 12px; border-radius: 20px; font-weight: 600; display: inline-block; }
    </style>
</head>
<body>
    <nav class="sidebar">
        <div class="logo-area">
            <div class="logo-icon">A</div>
            <div>Asset<span style="color:var(--primary)">Flow</span></div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="/dashboard">🏠 Dashboard</a></li>
            <li class="nav-item"><a href="/data-aset">📊 Data Aset</a></li>
            <li class="nav-item"><a href="/history">📅 History Peminjaman</a></li>
            <li class="nav-item"><a href="/kategori" class="active">📂 Kategori</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="header">
            <div>
                <h1 style="margin:0; font-size:1.5rem;">Kategori Aset</h1>
                <p style="margin:5px 0 0 0; color:var(--text-muted);">Pilih kategori untuk melihat detail inventaris.</p>
            </div>
        </div>

        <div class="grid-cat">
            <!-- 1. ELEKTRONIK (Dummy Link) -->
            <a href="/data-aset" class="cat-card">
                <div class="cat-icon">💻</div>
                <div class="cat-title">Elektronik</div>
                <div class="cat-desc">Laptop, PC, Printer, dll.</div>
                <div class="cat-count">142 Item</div>
            </a>

            <!-- 2. KENDARAAN (LINK KE HALAMAN KENDARAAN) -->
            <a href="/kategori-kendaraan" class="cat-card" style="border: 2px solid var(--primary);">
                <div class="cat-icon">🚚</div>
                <div class="cat-title">Kendaraan Dinas</div>
                <div class="cat-desc">Mobil Dinas, Pickup, Motor</div>
                <div class="cat-count">12 Item</div>
            </a>

            <!-- 3. FURNITURE (Dummy Link) -->
            <a href="/data-aset" class="cat-card">
                <div class="cat-icon">🪑</div>
                <div class="cat-title">Furniture</div>
                <div class="cat-desc">Meja, Kursi, Lemari</div>
                <div class="cat-count">85 Item</div>
            </a>

            <!-- 4. ALAT BERAT (Dummy Link) -->
            <a href="/data-aset" class="cat-card">
                <div class="cat-icon">🔧</div>
                <div class="cat-title">Alat Berat</div>
                <div class="cat-desc">Excavator, Bulldozer</div>
                <div class="cat-count">5 Item</div>
            </a>
            
            <!-- 5. Tambah Kategori -->
            <div class="cat-card" style="background: #f9fafb; border: 2px dashed #d1d5db; display: grid; place-items: center; cursor: pointer;">
                <div style="font-size:2.5rem; color:var(--text-muted);">+</div>
                <div style="margin-top:0.5rem; font-weight:600;">Tambah Kategori</div>
            </div>
        </div>
    </main>
</body>
</html>