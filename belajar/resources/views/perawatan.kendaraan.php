<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perawatan Kendaraan - Sistem Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --success: #10b981; /* BR - Ringan */
            --warning: #f59e0b; /* BS - Sedang */
            --danger: #ef4444;   /* BT - Tinggi */
            --info: #3b82f6;    /* BU - Umum */
            --radius: 12px;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }

        /* SIDEBAR & HEADER (Standard) */
        .sidebar { width: 260px; background: #1f2937; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo-area { padding: 2rem 1.5rem; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid #374151; display: flex; gap: 10px; align-items: center; }
        .logo-icon { width: 32px; height: 32px; background: var(--primary); border-radius: 8px; display: grid; place-items: center; font-weight: bold; }
        .logo-text { font-size: 1.1rem; font-weight: 700; letter-spacing: -0.025em; }
        .nav-menu { padding: 1.5rem 1rem; list-style: none; flex: 1; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #9ca3af; text-decoration: none; border-radius: 8px; margin-bottom: 4px; font-weight: 500; }
        .nav-item a:hover, .nav-item a.active { background-color: #374151; color: white; }
        .nav-item a.active { background-color: var(--primary); }

        .main-content { flex: 1; overflow-y: auto; display: flex; flex-direction: column; }
        .header { background: var(--bg-card); border-bottom: 1px solid var(--border); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }

        /* FILTER BAR */
        .filter-group { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
        .search-input { padding: 0.6rem 1rem; border: 1px solid var(--border); border-radius: 8px; outline: none; width: 300px; }
        .form-select { padding: 0.6rem 2rem 0.6rem 1rem; border: 1px solid var(--border); border-radius: 50px; background: white; cursor: pointer; font-weight: 500; appearance: none; -webkit-appearance: none; outline: none; }
        .form-select { background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234f46e5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3epolyline points='6 9 12 15 18 9'%3e/polyline%3e/svg%3e"); background-repeat: no-repeat; background-position: right 0.7rem center; background-size: 1rem; }
        .btn-add { background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; }

        /* STATS CARDS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius); border: 1px solid var(--border); display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-md); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: grid; place-items: center; font-size: 1.5rem; background: #e0e7ff; color: var(--primary); }
        .stat-info h4 { font-size: 0.8rem; color: var(--text-muted); font-weight: 500; margin: 0; }
        .stat-info p { font-size: 1.5rem; font-weight: 700; margin: 0.25rem 0 0; color: var(--text-main); }
        .stat-label { font-size: 0.8rem; color: var(--text-muted); }

        /* LEGEND BADGES */
        .legend-grid { display: flex; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border); }
        .legend-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 500; }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-br { background: var(--success); }
        .dot-bs { background: var(--warning); }
        .dot-bt { background: var(--danger); }
        .dot-bu { background: var(--info); }

        /* BADGE TABLE */
        .badge-cat { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .bg-br { background: #d1fae5; color: #065f46; }
        .bg-bs { background: #fef3c7; color: #92400e; }
        .bg-bt { background: #fee2e2; color: #991b1b; }
        .bg-bu { background: #dbeafe; color: #1e40af; }

        /* TABLE */
        .table-container { background: var(--bg-card); border-radius: var(--radius); box-shadow: var(--shadow-md); overflow: hidden; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { background: #f9fafb; padding: 1rem; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; border-bottom: 1px solid var(--border); text-align: left; }
        td { padding: 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:hover td { background-color: #f9fafb; }
        .text-right { text-align: right; }
        
        .btn-detail { padding: 6px 12px; border-radius: 6px; border: 1px solid var(--border); background: white; cursor: pointer; font-size: 0.8rem; color: var(--primary); }
        .btn-detail:hover { background: var(--primary); color: white; }

        /* MODAL DETAIL */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 100; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(4px); }
        .modal-overlay.open { opacity: 1; visibility: visible; }
        .modal { background: white; width: 900px; max-width: 95%; border-radius: var(--radius); box-shadow: var(--shadow-md); display: flex; flex-direction: column; overflow: hidden; height: 90vh; }
        
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: #f9fafb; }
        .modal-title { font-size: 1.25rem; font-weight: 700; }
        .modal-body { flex: 1; overflow-y: auto; padding: 2rem; }

        /* TABS */
        .tabs { display: flex; gap: 1rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; }
        .tab-btn { padding: 0.75rem 1.5rem; background: none; border: none; border-bottom: 2px solid transparent; font-weight: 500; color: var(--text-muted); cursor: pointer; }
        .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }
        .tab-content { display: none; animation: fadeIn 0.3s ease; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* INFO GRID */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .info-item label { display: block; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px; font-weight: 500; }
        .info-item div { font-size: 1rem; font-weight: 500; color: var(--text-main); }

        /* COST TABLE */
        .cost-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; margin-bottom: 1rem; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
        .cost-table th { background: #f9fafb; padding: 0.75rem; font-weight: 600; font-size: 0.75rem; text-align: left; border-bottom: 1px solid var(--border); }
        .cost-table td { padding: 0.75rem; border-bottom: 1px solid #f3f4f6; }
        .total-row { background: #f9fafb; font-weight: 700; font-size: 1rem; }
        .total-row td { border-bottom: none; }

    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="logo-area">
            <div class="logo-icon">A</div>
            <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="/dashboard">🏠 Dashboard</a></li>
            <li class="nav-item"><a href="/data-aset">📊 Data Aset</a></li>
            <li class="nav-item"><a href="/kategori-kendaraan">🚚 Kategori Kendaraan</a></li>
            <li class="nav-item"><a href="/perawatan-kendaraan" class="active">🔧 Perawatan</a></li>
        </ul>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- HEADER -->
        <header class="header">
            <div class="filter-group">
                <input type="text" class="search-input" placeholder="Cari Plat / Merk..." onkeyup="renderTable()">
                
                <select class="form-select" id="filterMonth" onchange="renderTable()">
                    <option value="">Semua Bulan</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>

                <select class="form-select" id="filterYear" onchange="renderTable()">
                    <option value="">Semua Tahun</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
            </div>

            <div class="user-profile">
                <div style="text-align: right;">
                    <div style="font-weight: 600; font-size: 0.9rem;">Administrator</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">IT Dept</div>
                </div>
                <img src="https://picsum.photos/seed/admin/100/100" alt="Avatar" class="user-avatar">
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content-body" style="padding: 2rem;">
            
            <!-- 1. RINGKASAN STATISTIK -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🔧</div>
                    <div class="stat-info">
                        <h4>Total Perawatan</h4>
                        <p id="statTotal">0</p>
                        <div class="stat-label">Kunjungan</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #d1fae5; color: #065f46;">💰</div>
                    <div class="stat-info">
                        <h4>Total Biaya</h4>
                        <p id="statCost" style="color: #065f46;">Rp 0</p>
                        <div class="stat-label">Akumulasi</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #ffedd5; color: #92400e;">📆</div>
                    <div class="stat-info">
                        <h4>Terbanyak</h4>
                        <p id="statType">Servis Berkala</p>
                        <div class="stat-label">Jenis Perawatan</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">📅</div>
                    <div class="stat-info">
                        <h4 id="statPeriod">-</h4>
                        <div class="stat-label">Periode Terakhir</div>
                    </div>
                </div>
            </div>

            <!-- 2. KATEGORI BIAYA (LEGEND) -->
            <div class="legend-grid">
                <div class="legend-item"><div class="dot dot-br"></div> BR (Biaya Ringan)</div>
                <div class="legend-item"><div class="dot dot-bs"></div> BS (Biaya Sedang)</div>
                <div class="legend-item"><div class="dot dot-bt"></div> BT (Biaya Tinggi)</div>
                <div class="legend-item"><div class="dot dot-bu"></div> BU (Biaya Umum)</div>
            </div>

            <!-- 3. TABEL RIWAYAT PERAWATAN -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No. Polisi</th>
                            <th>Merk Kendaraan</th>
                            <th>Tgl Perawatan</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Jenis Perawatan</th>
                            <th class="text-right">Total Biaya</th>
                            <th>Kategori</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="maintTable">
                        <!-- JS Injection -->
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <!-- MODAL DETAIL -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Detail Perawatan</div>
                <button class="btn-detail" style="background: none; font-size: 1.5rem;" onclick="closeModal()">&times;</button>
            </div>
            
            <div class="modal-body">
                <div class="tabs">
                    <button class="tab-btn active" onclick="switchTab('info')">Info Kendaraan</button>
                    <button class="tab-btn" onclick="switchTab('maint')">Info Perawatan</button>
                    <button class="tab-btn" onclick="switchTab('cost')">Rincian Biaya</button>
                </div>

                <!-- A. INFO KENDARAAN -->
                <div id="info" class="tab-content active">
                    <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Data Kendaraan</h3>
                    <div class="info-grid">
                        <div class="info-item"><label>No. Polisi</label><div id="d_plat" style="font-size: 1.1rem; color: var(--primary); font-weight: 700;"></div>
                        <div class="info-item"><label>Merk</label><div id="d_merk"></div></div>
                        <div class="info-item"><label>Type</label><div id="d_type"></div></div>
                        <div class="info-item"><label>Jenis</label><div id="d_jenis"></div></div>
                        <div class="info-item"><label>Pengguna</label><div id="d_user"></div></div>
                        <div class="info-item"><label>Tanggal</label><div id="d_date"></div></div>
                        <div class="info-item"><label>Jenis Perawatan</label><div id="d_jenis_maint"></div></div>
                        <div class="info-item"><label>Keterangan</label><div id="d_ket"></div></div>
                    </div>
                </div>

                <!-- B. INFO PERAWATAN -->
                <div id="maint" class="tab-content">
                    <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Informasi Perawatan</h3>
                    <div class="info-grid">
                        <div class="info-item"><label>Tanggal</label><div id="dm_date"></div></div>
                        <div class="info-item"><label>Bulan</label><div id="dm_month"></div></div>
                        <div class="info-item"><label>Tahun</label><div id="dm_year"></div></div>
                        <div class="info-item"><label>Kategori</label><div id="dm_cat"></div></div>
                        <div class="info-item"><label>Jenis Perawatan</label><div id="dm_type"></div></div>
                        <div class="info-item"><label>Total Biaya</label><div id="dm_cost" style="color: var(--primary); font-weight: 700;"></div></div>
                    </div>
                </div>

                <!-- C. RINCIAN BIAYA -->
                <div id="cost" class="tab-content">
                    <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Rincian Biaya</h3>
                    <table class="cost-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Item</th>
                                <th class="text-right">Jumlah Biaya</th>
                            </tr>
                        </thead>
                        <tbody id="costItemsBody">
                            <!-- Items JS -->
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="2" style="text-align: right; padding-right: 1.5rem;">TOTAL</td>
                                <td class="text-right" id="modalTotalCost">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- DATA DUMMY (Lengkap) ---
        const dummyMaintenances = [
            {
                id: 1,
                plat: "B 1983 TUA",
                merk: "Toyota",
                type: "Innova Reborn",
                jenis: "MPV",
                user: "Bagian Umum",
                date: "10 Okt 2023",
                month: "Oktober",
                year: 2023,
                jenis_maint: "Servis Berkala",
                ket: "Ganti Oli & Filter, Cek Rem",
                category: "BS", // Sedang
                total: 1500000,
                items: [
                    { name: "Oli Mesin 0W-20", price: 500000 },
                    { name: "Oli Filter", price: 150000 },
                    { name: "Busi Rem Depan", price: 350000 },
                    { name: "Minyak Rem Belakang", price: 350000 },
                    { name: "Kampas Rem", price: 100000 },
                    { name: "Jasa Service", price: 50000 }
                ]
            },
            {
                id: 2,
                plat: "B 1983 TUA",
                merk: "Toyota",
                type: "Innova Reborn",
                jenis: "MPV",
                user: "Bagian Umum",
                date: "20 Sep 2023",
                month: "September",
                year: 2023,
                jenis_maint: "Ganti Ban",
                ket: "Ban 4 buah Dunlop",
                category: "BT", // Tinggi
                total: 3200000,
                items: [
                    { name: "Ban Dunlop 205/55 R17", price: 2500000 },
                    { name: "Balancing & Spooring", price: 400000 },
                    { name: "Nitrogen & Tambal", price: 300000 }
                ]
            },
            {
                id: 3,
                plat: "B 9881 PAH",
                merk: "Toyota",
                type: "Hilux D-Cabin",
                jenis: "Pick Up",
                user: "Operasional",
                date: "15 Agustus 2023",
                month: "Agustus",
                year: 2023,
                jenis_maint: "Tune Up",
                ket: "Pemasangan Aksesoris",
                category: "BR", // Ringan
                total: 750000,
                items: [
                    { name: "Pajak Hard Top", price: 300000 },
                    { name: "Cover Jok", price: 200000 },
                    { name: "Tape Deck", price: 100000 },
                    { name: "Karet Footstep", price: 150000 }
                ]
            },
            {
                id: 4,
                plat: "B 1029 XLA",
                merk: "Honda",
                type: "CR-V Turbo",
                jenis: "SUV",
                user: "Direktur Utama",
                date: "05 Juli 2023",
                month: "Juli",
                year: 2023,
                jenis_maint: "Lampu Depan Putus",
                ket: "Ganti Bohlam Kiri",
                category: "BU", // Umum
                total: 250000,
                items: [
                    { name: "Bohlamp H4", price: 150000 },
                    { name: "Jasa Pasang", price: 100000 }
                ]
            }
        ];

        // Load LocalStorage or Dummy
        let maintenances = JSON.parse(localStorage.getItem('maintData')) || dummyMaintenances;

        function saveData() { localStorage.setItem('maintData', JSON.stringify(maintenances)); }
        const formatRupiah = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n);

        // --- RENDER TABLE ---
        function renderTable() {
            const tbody = document.getElementById('maintTable');
            const filterMonth = document.getElementById('filterMonth').value;
            const filterYear = document.getElementById('filterYear').value;
            const searchTxt = document.querySelector('.search-input').value.toLowerCase();
            
            tbody.innerHTML = '';
            
            // Stats Calculation for Header
            let grandTotal = 0;
            let counts = { BR:0, BS:0, BT:0, BU:0 };
            const typeCount = {};

            maintenances.forEach((m, index) => {
                // Filter Logic
                if (filterMonth && m.month !== filterMonth) return;
                if (filterYear && m.year != filterYear) return;
                if (searchTxt && !m.plat.toLowerCase().includes(searchTxt) && !m.merk.toLowerCase().includes(searchTxt)) return;

                // Stats
                grandTotal += m.total;
                if(counts[m.category] !== undefined) counts[m.category]++;
                if(typeCount[m.jenis_maint]) {
                    typeCount[m.jenis_maint] = (typeCount[m.jenis_maint] || 0) + 1;
                }

                // Badge Class
                let badgeClass = '';
                if(m.category === 'BR') badgeClass = 'bg-br';
                else if(m.category === 'BS') badgeClass = 'bg-bs';
                else if(m.category === 'BT') badgeClass = 'bg-bt';
                else badgeClass = 'bg-bu';

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="font-weight: 600;">${m.plat}</td>
                    <td>${m.merk} ${m.type}</td>
                    <td>${m.date}</td>
                    <td>${m.month}</td>
                    <td>${m.year}</td>
                    <td>${m.jenis_maint}</td>
                    <td class="text-right" style="font-weight: 600;">${formatRupiah(m.total)}</td>
                    <td><span class="badge-cat ${badgeClass}">${m.category}</span></td>
                    <td style="text-align: center;">
                        <button class="btn-detail" onclick="openDetail(${m.id})">Detail</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // Update Stats Cards
            document.getElementById('statTotal').innerText = maintenances.length;
            document.getElementById('statCost').innerText = formatRupiah(grandTotal);
            
            // Find most frequent type
            let maxType = Object.keys(typeCount).reduce((a, b) => typeCount[a] > typeCount[b] ? a : b, '-');
            document.getElementById('statType').innerText = maxType === '-' ? '-' : maxType;

            // Find most recent
            const last = maintenances[0];
            if(last) document.getElementById('statPeriod').innerText = `${last.month} ${last.year}`;
        }

        // --- OPEN DETAIL ---
        function openDetail(id) {
            const m = maintenances.find(x => x.id === id);
            if(!m) return;

            // Tab A: Info Kendaraan
            document.getElementById('d_plat').innerText = m.plat;
            document.getElementById('d_merk').innerText = m.merk;
            document.getElementById('d_type').innerText = m.type;
            document.getElementById('d_jenis').innerText = m.jenis;
            document.getElementById('d_user').innerText = m.user;
            
            // Tab B: Info Perawatan
            document.getElementById('dm_date').innerText = m.date;
            document.getElementById('dm_month').innerText = m.month;
            document.getElementById('dm_year').innerText = m.year;
            document.getElementById('dm_cat').innerText = m.category;
            document.getElementById('dm_type').innerText = m.jenis_maint;
            document.getElementById('dm_cost').innerText = formatRupiah(m.total);

            // Tab C: Rincian Biaya
            const tbodyCost = document.getElementById('costItemsBody');
            tbodyCost.innerHTML = '';
            m.items.forEach((item, idx) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="width: 50px;">${idx + 1}</td>
                    <td>${item.name}</td>
                    <td class="text-right">${formatRupiah(item.price)}</td>
                `;
                tbodyCost.appendChild(tr);
            });
            document.getElementById('modalTotalCost').innerText = formatRupiah(m.total);

            switchTab('info');
            document.getElementById('detailModal').classList.add('open');
        }

        function closeModal() { document.getElementById('detailModal').classList.remove('open'); }
        function switchTab(id) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }

        // Init
        renderTable();
    </script>
</body>
</html>