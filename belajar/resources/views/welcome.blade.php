<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #64748b;
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --radius: 12px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }

        /* --- STYLE UTAMA (SAMA KAYA DATA ASET) --- */
        
        /* SIDEBAR */
        .sidebar {
            width: 260px; background: #1f2937; color: white; display: flex; flex-direction: column;
            transition: 0.3s; flex-shrink: 0;
        }
        .logo-area { padding: 2rem 1.5rem; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #374151; }
        .logo-icon { width: 32px; height: 32px; background: var(--primary); border-radius: 8px; display: grid; place-items: center; font-weight: bold; }
        .logo-text { font-size: 1.1rem; font-weight: 700; letter-spacing: -0.025em; }
        
        .nav-menu { padding: 1.5rem 1rem; flex: 1; }
        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 12px 16px;
            color: #9ca3af; text-decoration: none; border-radius: 8px; margin-bottom: 4px;
            transition: 0.2s; font-size: 0.9rem; font-weight: 500;
        }
        .nav-item:hover, .nav-item.active { background-color: #374151; color: white; }
        .nav-item.active { background-color: var(--primary); }

        /* MAIN CONTENT */
        .main-content { flex: 1; overflow-y: auto; display: flex; flex-direction: column; }
        
        /* HEADER (SAMA KAYA DATA ASET) */
        .header {
            background: var(--bg-card); border-bottom: 1px solid var(--border); padding: 1rem 2rem;
            display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10;
        }
        .search-bar {
            background: var(--bg-body); padding: 0.5rem 1rem; border-radius: 8px;
            width: 300px; display: flex; align-items: center; gap: 8px; border: 1px solid transparent;
        }
        .search-bar:focus-within { border-color: var(--primary); background: white; }
        .search-bar input { border: none; background: transparent; outline: none; width: 100%; font-size: 0.9rem; }
        
        /* PROFIL KANAN ATAS (SAMA KAYA DATA ASET) */
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }

        /* --- STYLE KHUSUS DASHBOARD --- */
        .content-body { padding: 2rem; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .page-title h2 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
        .page-title p { color: var(--text-muted); font-size: 0.9rem; margin-top: 4px; }
        
        .btn-add {
            background: var(--primary); color: white; border: none; padding: 10px 20px;
            border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2); transition: 0.2s; text-decoration: none;
        }
        .btn-add:hover { background: var(--primary-hover); transform: translateY(-1px); }

        /* STATS CARDS */
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card {
            background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius);
            box-shadow: var(--shadow-sm); border: 1px solid var(--border); display: flex; align-items: center; gap: 1rem;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px; display: grid; place-items: center; font-size: 1.5rem;
        }
        .icon-blue { background: #e0e7ff; color: var(--primary); }
        .icon-green { background: #d1fae5; color: var(--success); }
        .icon-orange { background: #ffedd5; color: var(--warning); }
        
        .stat-info h4 { font-size: 0.85rem; color: var(--text-muted); font-weight: 500; margin: 0; }
        .stat-info p { font-size: 1.5rem; font-weight: 700; margin-top: 2px; }

        /* CONTENT GRID */
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        
        /* CARD STYLE UMUM */
        .card { background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem; }
        .card-title { font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin: 0; }

        /* ACTION BUTTONS */
        .action-btn { display: inline-flex; align-items: center; gap: 8px; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3); }
        .btn-primary:hover { background: #4338ca; transform: translateY(-2px); }
        .btn-outline { background: white; border: 1px solid var(--border); color: var(--text-main); }
        .btn-outline:hover { background: #f9fafb; border-color: #d1d5db; }

        /* ACTIVITY TIMELINE */
        .timeline-item { display: flex; gap: 1rem; margin-bottom: 1.5rem; position: relative; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-icon { width: 40px; height: 40px; border-radius: 50%; display: grid; place-items: center; font-size: 1.2rem; flex-shrink: 0; background: #f3f4f6; z-index: 2; }
        .timeline-content { flex: 1; }
        .timeline-content h5 { margin: 0 0 4px 0; font-size: 0.95rem; font-weight: 600; }
        .timeline-content p { margin: 0; font-size: 0.85rem; color: var(--text-muted); }
        .timeline-line { position: absolute; left: 20px; top: 40px; bottom: -30px; width: 2px; background: #e5e7eb; z-index: 1; }
        .timeline-item:last-child .timeline-line { display: none; }

        /* CATEGORY LIST */
        .cat-item { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .cat-info { display: flex; align-items: center; gap: 10px; }
        .cat-icon { width: 32px; height: 32px; background: #f3f4f6; border-radius: 8px; display: grid; place-items: center; }
        .progress-bar { height: 8px; background: #f3f4f6; border-radius: 4px; flex: 1; margin: 0 1rem; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 4px; }

        /* ALERTS LIST */
        .alert-item { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem; border: 1px solid #fee2e2; background: #fef2f2; border-radius: 8px; margin-bottom: 0.75rem; }
        .alert-text { font-size: 0.9rem; font-weight: 500; color: #991b1b; }

        @media(max-width: 768px) {
            .content-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR (SAMA PERSIS DENGAN DATA ASET) -->
    <nav class="sidebar">
        <div class="logo-area">
            <div class="logo-icon">A</div>
            <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
        </div>
        <div class="nav-menu">
            <a href="/" class="nav-item active">🏠 Dashboard</a>
            <a href="/data-aset" class="nav-item">📊 Data Aset</a>
            <a href="/history" class="nav-item">📅 History Peminjaman</a>
            <a href="/kategori" class="nav-item">📂 Kategori</a>
        </div>
    </nav>

    <!-- MAIN CONTENT WRAPPER -->
    <main class="main-content">
        
        <!-- HEADER (SAMA PERSIS DENGAN DATA ASET) -->
        <header class="header">
            <div class="search-bar">
                <span>🔍</span>
                <input type="text" placeholder="Cari aset...">
            </div>
            <!-- PROFIL KANAN ATAS (SAMA) -->
            <div class="user-profile">
                <div style="text-align: right;">
                    <div style="font-weight: 600; font-size: 0.9rem;">Administrator</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">IT Dept</div>
                </div>
                <img src="https://picsum.photos/seed/admin/100/100" alt="Avatar" class="user-avatar">
            </div>
        </header>

        <!-- ISI DASHBOARD KHUSUS -->
        <div class="content-body">
            
            <!-- Title & Action -->
            <div class="page-header">
                <div class="page-title">
                    <h2>Dashboard Utama</h2>
                    <p>Ringkasan aktivitas dan status inventaris hari ini.</p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="/data-aset" class="action-btn btn-primary">
                        <span>+ Tambah Aset</span>
                    </a>
                    <a href="/data-aset" class="action-btn btn-outline">
                        <span>📋 Lihat Data</span>
                    </a>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon icon-blue">📦</div>
                    <div class="stat-info">
                        <h4>Total Aset</h4>
                        <p id="dashTotal">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-green">💰</div>
                    <div class="stat-info">
                        <h4>Nilai Total</h4>
                        <p id="dashValue" style="font-size: 1.1rem; margin-top: 6px;">Rp 0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-orange">🔧</div>
                    <div class="stat-info">
                        <h4>Perlu Perbaikan</h4>
                        <p id="dashRepair">0</p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                
                <!-- KOLOM KIRI: AKTIVITAS -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aktivitas Terbaru</h3>
                        <a href="/data-aset" style="font-size: 0.85rem; color: var(--primary); text-decoration: none;">Lihat Semua</a>
                    </div>
                    
                    <div class="timeline-item" id="latest-activity">
                        <div class="timeline-line"></div>
                        <div class="timeline-icon" style="background: #e0e7ff; color: var(--primary);">👤</div>
                        <div class="timeline-content">
                            <h5 id="act-name">Menunggu Data...</h5>
                            <p id="act-code">Belum ada aktivitas tercatat</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-line"></div>
                        <div class="timeline-icon" style="background: #d1fae5; color: var(--success);">✅</div>
                        <div class="timeline-content">
                            <h5>Andi Pratama mengembalikan <strong>Kursi Kerja</strong></h5>
                            <p>AST-045 • 1 Jam yang lalu</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-line"></div>
                        <div class="timeline-icon" style="background: #fee2e2; color: var(--danger);">🔧</div>
                        <div class="timeline-content">
                            <h5>Status <strong>Printer Epson L3210</strong> diubah ke Perbaikan</h5>
                            <p>Oleh Admin • 3 Jam yang lalu</p>
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN: KATEGORI & ALERT -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Distribusi Kategori</h3>
                        </div>
                        
                        <div class="cat-item">
                            <div class="cat-info">
                                <div class="cat-icon">💻</div>
                                <span style="font-size: 0.9rem; font-weight: 500;">Elektronik</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 65%; background: var(--primary);"></div>
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 600;">65%</span>
                        </div>

                        <div class="cat-item">
                            <div class="cat-info">
                                <div class="cat-icon">🪑</div>
                                <span style="font-size: 0.9rem; font-weight: 500;">Furniture</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 25%; background: var(--success);"></div>
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 600;">25%</span>
                        </div>

                        <div class="cat-item">
                            <div class="cat-info">
                                <div class="cat-icon">🚚</div>
                                <span style="font-size: 0.9rem; font-weight: 500;">Kendaraan</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 10%; background: var(--warning);"></div>
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 600;">10%</span>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Perlu Perhatian ⚠️</h3>
                        </div>
                        
                        <div class="alert-item">
                            <div class="alert-text">AC Ruang Meeting Mati</div>
                            <button style="background: none; border: 1px solid var(--danger); color: var(--danger); border-radius: 4px; cursor: pointer; font-size: 0.75rem; padding: 2px 6px;">Cek</button>
                        </div>

                        <div class="alert-item">
                            <div class="alert-text">Printer Lantai 2 Kertas Habis</div>
                            <button style="background: none; border: 1px solid var(--danger); color: var(--danger); border-radius: 4px; cursor: pointer; font-size: 0.75rem; padding: 2px 6px;">Cek</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- SCRIPT LOGIC -->
    <script>
        function updateDashboard() {
            const data = JSON.parse(localStorage.getItem('inventoryData')) || [];
            const total = data.length;
            document.getElementById('dashTotal').innerText = total;
            const totalValue = data.reduce((sum, item) => sum + Number(item.price), 0);
            document.getElementById('dashValue').innerText = formatRupiah(totalValue);
            const repairCount = data.filter(i => i.status === 'Perbaikan' || i.status === 'Rusak').length;
            document.getElementById('dashRepair').innerText = repairCount + " Item";
            if (data.length > 0) {
                const lastItem = data[0]; 
                const actName = document.getElementById('act-name');
                const actCode = document.getElementById('act-code');
                if(actName && actCode) {
                    actName.innerHTML = `Aset baru ditambahkan: <strong>${lastItem.name}</strong>`;
                    actCode.innerHTML = `${lastItem.code} • Baru saja`;
                    const icon = document.querySelector('#latest-activity .timeline-icon');
                    if(icon) {
                        icon.innerHTML = '📦';
                        icon.style.background = '#e0e7ff';
                        icon.style.color = 'var(--primary)';
                    }
                }
            }
        }
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        }
        window.addEventListener('DOMContentLoaded', updateDashboard);
    </script>

</body>
</html>