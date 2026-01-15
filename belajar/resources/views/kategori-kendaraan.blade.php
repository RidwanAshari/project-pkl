<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan Dinas - Sistem Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius: 12px;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }

        /* SIDEBAR */
        .sidebar { width: 260px; background: #1f2937; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .logo-area { padding: 2rem 1.5rem; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid #374151; display: flex; gap: 10px; align-items: center; }
        .logo-icon { width: 32px; height: 32px; background: var(--primary); border-radius: 8px; display: grid; place-items: center; font-weight: bold; }
        .logo-text { font-size: 1.1rem; font-weight: 700; letter-spacing: -0.025em; }
        .nav-menu { padding: 1.5rem 1rem; list-style: none; flex: 1; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #9ca3af; text-decoration: none; border-radius: 8px; margin-bottom: 4px; font-weight: 500; }
        .nav-item a:hover, .nav-item a.active { background-color: #374151; color: white; }
        .nav-item a.active { background-color: var(--primary); }

        .main-content { flex: 1; overflow-y: auto; display: flex; flex-direction: column; }
        
        /* HEADER */
        .header { background: var(--bg-card); border-bottom: 1px solid var(--border); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; }
        .search-filter-group { display: flex; gap: 1rem; }
        
        /* STYLE GLOBAL SELECT (DROPPDOWN PILL SEMUA JENIS) */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: white;
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 10px 40px 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
            transition: 0.2s;
            width: 220px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234f46e5' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3epolyline points='6 9 12 15 18 9'%3e/polyline%3e/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
        }
        select:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.15);
        }

        .btn-sm { padding: 0.6rem 1.2rem; border-radius: 6px; border: none; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .btn-sm:hover { opacity: 0.9; }

        .content-body { padding: 2rem; }

        /* TABLE */
        .table-container { background: var(--bg-card); border-radius: var(--radius); box-shadow: var(--shadow-md); overflow: hidden; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { background: #f9fafb; padding: 1rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem; border-bottom: 1px solid var(--border); text-align: left; }
        td { padding: 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .badge-plate { background: #e0e7ff; color: var(--primary); padding: 4px 8px; border-radius: 4px; font-family: monospace; font-weight: 700; border: 1px solid #c7d2fe; }
        .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-active { background: #d1fae5; color: #065f46; }
        .status-warning { background: #fef3c7; color: #92400e; }
        .status-expired { background: #fee2e2; color: #991b1b; }

        /* CARD */
        .card-lg { padding: 2rem; background: white; border-radius: var(--radius); border: 1px solid var(--border); display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .icon-box-lg { width: 70px; height: 70px; border-radius: 16px; display: grid; place-items: center; font-size: 2.5rem; }

        /* MODAL */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 100; opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(4px); }
        .modal-overlay.open { opacity: 1; visibility: visible; }
        .modal { background: white; width: 1100px; max-width: 98%; height: 90vh; border-radius: var(--radius); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; overflow: hidden; }
        .modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: #f9fafb; }
        .modal-body { flex: 1; overflow-y: auto; padding: 2rem; }
        
        /* TABS */
        .tabs { display: flex; gap: 1rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; overflow-x: auto; }
        .tab-btn { padding: 0.75rem 1.25rem; background: none; border: none; border-bottom: 2px solid transparent; font-weight: 500; color: var(--text-muted); cursor: pointer; white-space: nowrap; }
        .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }
        .tab-content { display: none; animation: fadeIn 0.3s ease; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* FORM INPUTS */
        .form-add-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
        .form-add-group { margin-bottom: 1rem; }
        .form-label-add { display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 6px; color: var(--text-main); }
        .form-input-add { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 6px; font-size: 0.9rem; outline: none; }
        .form-input-add:focus { border-color: var(--primary); box-shadow: 0 0 0 2px #e0e7ff; }
        .form-full { grid-column: span 2; }
        .btn-save { width: 100%; background: var(--primary); color: white; padding: 10px; border-radius: 6px; border: none; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .form-section-title { grid-column: span 2; font-size: 0.95rem; font-weight: 700; color: var(--primary); margin-top: 1.5rem; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border); padding-bottom: 5px; }

        /* UPLOAD PHOTO GRID */
        .photo-upload-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 1rem; }
        .photo-box { position: relative; aspect-ratio: 4/3; background: #f9fafb; border: 1px dashed #d1d5db; border-radius: 8px; cursor: pointer; overflow: hidden; display: flex; justify-content: center; align-items: center; transition: 0.2s; }
        .photo-box:hover { border-color: var(--primary); background: #f3f4f6; }
        .photo-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
        .photo-preview { width: 100%; height: 100%; object-fit: cover; display: none; }
        .photo-preview.show { display: block; }
        .photo-icon { font-size: 2rem; color: #9ca3af; pointer-events: none; }

        /* PREVIEW IMAGE MODAL */
        .preview-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 200; display: none; justify-content: center; align-items: center; }
        .preview-modal.open { display: flex; }
        .preview-img { max-width: 90%; max-height: 90%; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .close-preview { position: absolute; top: 2rem; right: 2rem; color: white; font-size: 2rem; cursor: pointer; }

        @media(max-width: 768px) {
            .modal { width: 100%; height: 100%; border-radius: 0; }
            .photo-upload-grid { grid-template-columns: 1fr 1fr; }
        }
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
            <li class="nav-item"><a href="/history">📅 History Peminjaman</a></li>
            <li class="nav-item"><a href="/kategori" class="active">🚚 Kategori</a></li>
        </ul>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- HEADER -->
        <header class="header">
            <div class="search-filter-group">
                <!-- Dropdown Pilihan (Beranda, Identitas, dll) -->
                <select id="viewSelector" onchange="switchMainView(this.value)">
                    <option value="beranda">🏠 Beranda</option>
                    <option value="identitas">🪪 Identitas</option>
                    <option value="referensi">📚 Referensi</option>
                    <option value="laporan">📄 Laporan</option>
                </select>

                <!-- Search Text -->
                <input type="text" placeholder="Cari Plat / Merk..." style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; width: 250px;" onkeyup="renderTable()">
                
                <!-- Filter Jenis -->
                <select onchange="renderTable()">
                    <option value="">Semua Jenis</option>
                    <option value="MPV">MPV</option>
                    <option value="SUV">SUV</option>
                    <option value="Pick Up">Pick Up</option>
                </select>
            </div>
            <button class="btn-sm" style="background: var(--primary); color: white;" onclick="openAddModal()">+ Tambah Kendaraan</button>
        </header>

        <!-- BODY CONTENT (4 VIEW) -->
        <div class="content-body">

            <!-- 1. VIEW: BERANDA (DAFTAR) -->
            <div id="view-beranda">
                <h2 style="margin-bottom: 1.5rem;">Manajemen Armada Dinas</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Plat & Merk</th>
                                <th>Jenis & Model</th>
                                <th>Pengguna</th>
                                <th>Status STNK</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="vehicleTable">
                            <!-- JS Injection -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. VIEW: IDENTITAS -->
            <div id="view-identitas" style="display: none;">
                <h2 style="margin-bottom: 1.5rem;">Ringkasan Identitas</h2>
                <div class="card-lg">
                    <div class="icon-box-lg" style="background: #e0e7ff; color: var(--primary);">🚗</div>
                    <div>
                        <div style="font-size: 0.9rem; color: var(--text-muted);">Total Kendaraan</div>
                        <div id="id-total-veh" style="font-size: 2.5rem; font-weight: 800; line-height: 1;">0</div>
                    </div>
                </div>
                <div class="card-lg">
                    <div class="icon-box-lg" style="background: #fee2e2; color: var(--danger);">⚠️</div>
                    <div>
                        <div style="font-size: 0.9rem; color: var(--text-muted);">STNK Expired</div>
                        <div id="id-total-exp" style="font-size: 2.5rem; font-weight: 800; line-height: 1;">0</div>
                    </div>
                </div>
                <div class="card-lg">
                    <div class="icon-box-lg" style="background: #d1fae5; color: var(--success);">✅</div>
                    <div>
                        <div style="font-size: 0.9rem; color: var(--text-muted);">Kondisi Siap Pakai</div>
                        <div id="id-total-ready" style="font-size: 2.5rem; font-weight: 800; line-height: 1;">0</div>
                    </div>
                </div>
            </div>

            <!-- 3. VIEW: REFERENSI -->
            <div id="view-referensi" style="display: none;">
                <h2 style="margin-bottom: 1.5rem;">Kategori Perawatan</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="card-lg" style="justify-content: flex-start; padding: 3rem;">
                        <div class="icon-box-lg" style="background: #dbeafe; color: #2563eb;">🛢</div>
                        <div>
                            <div style="font-weight: 700; font-size: 1.25rem;">Bengkel Ringan (BR)</div>
                            <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 5px;">Ganti Oli & Filter, Spooring, Tune Up.</div>
                        </div>
                    </div>
                    <div class="card-lg" style="justify-content: flex-start; padding: 3rem;">
                        <div class="icon-box-lg" style="background: #fef3c7; color: #92400e;">🔧</div>
                        <div>
                            <div style="font-weight: 700; font-size: 1.25rem;">Bengkel Sedang (BS)</div>
                            <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 5px;">Servis Berkala, Perbaikan Mesin, Kelistrikan.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. VIEW: LAPORAN -->
            <div id="view-laporan" style="display: none;">
                <h2 style="margin-bottom: 1.5rem;">Laporan Biaya</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Plat & Merk</th>
                                <th>Total Perawatan</th>
                                <th>Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody id="reportBody">
                            <!-- JS Injection -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- MODAL DETAIL (TAB) -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal">
            <div class="modal-header">
                <div id="d_header" style="font-size: 1.25rem; font-weight: 700;">Detail Kendaraan</div>
                <button class="btn-sm" style="background:none; font-size: 1.2rem;" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tabs">
                    <button class="tab-btn active" onclick="switchTab('tab-a')">Info Utama</button>
                    <button class="tab-btn" onclick="switchTab('tab-b')">Identitas & Legalitas</button>
                    <button class="tab-btn" onclick="switchTab('tab-c')">Galeri</button>
                    <button class="tab-btn" onclick="switchTab('tab-d')">Teknis</button>
                    <button class="tab-btn" onclick="switchTab('tab-e')">Ringkasan Perawatan</button>
                </div>
                <!-- Content Tabs (Dummy Logic) -->
                <div id="tab-a" class="tab-content active">
                    <p style="text-align: center; color: var(--text-muted);">Data detail tersimpan...</p>
                </div>
                <div id="tab-b" class="tab-content"><p>Identitas...</p></div>
                <div id="tab-c" class="tab-content"><p>Galeri...</p></div>
                <div id="tab-d" class="tab-content"><p>Teknis...</p></div>
                <div id="tab-e" class="tab-content"><p>Perawatan...</p></div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH KENDARAAN (LENGKAP) -->
    <div class="modal-overlay" id="addModal">
        <div class="modal" style="height: auto; max-height: 95vh;">
            <div class="modal-header">
                <div style="font-size: 1.25rem; font-weight: 700;">Tambah Kendaraan Baru</div>
                <button class="btn-sm" style="background:none; font-size: 1.2rem;" onclick="closeAddModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form onsubmit="handleAdd(event)">
                    <!-- A. INFO UTAMA -->
                    <div class="form-section-title">A. Informasi Utama</div>
                    <div class="form-add-grid">
                        <div class="form-add-group">
                            <label class="form-label-add">Nomor Polisi</label>
                            <input type="text" id="f_plate" class="form-input-add" required placeholder="B 1234 XYZ">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Merk Kendaraan</label>
                            <input type="text" id="f_brand" class="form-input-add" required placeholder="Toyota">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Model</label>
                            <input type="text" id="f_model" class="form-input-add" placeholder="Kijang Innova">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Jenis</label>
                            <select id="f_type" class="form-input-add">
                                <option>MPV</option>
                                <option>SUV</option>
                                <option>Pick Up</option>
                            </select>
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Tahun</label>
                            <input type="number" id="f_year" class="form-input-add" placeholder="2020">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Pengguna</label>
                            <input type="text" id="f_user" class="form-input-add" placeholder="Bagian Umum">
                        </div>
                    </div>

                    <!-- B. IDENTITAS & LEGALITAS -->
                    <div class="form-section-title">B. Identitas & Legalitas</div>
                    <div class="form-add-grid">
                        <div class="form-add-group">
                            <label class="form-label-add">Nama Pemilik</label>
                            <input type="text" id="f_owner" class="form-input-add" placeholder="Perusahaan Daerah">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Exp STNK (Bulan)</label>
                            <input type="number" id="f_exp_m" class="form-input-add" placeholder="12">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Exp STNK (Tahun)</label>
                            <input type="number" id="f_exp_y" class="form-input-add" placeholder="2024">
                        </div>
                    </div>

                    <!-- C. INFO TEKNIS -->
                    <div class="form-section-title">C. Informasi Teknis</div>
                    <div class="form-add-grid">
                        <div class="form-add-group">
                            <label class="form-label-add">Isi Silinder (CC)</label>
                            <input type="text" id="f_cc" class="form-input-add" placeholder="2500 cc">
                        </div>
                        <div class="form-add-group">
                            <label class="form-label-add">Jumlah Penumpang</label>
                            <input type="number" id="f_seats" class="form-input-add" placeholder="7">
                        </div>
                    </div>

                    <!-- D. GALERI FOTO -->
                    <div class="form-section-title">D. Galeri Kendaraan</div>
                    <div class="photo-upload-grid">
                        <div class="photo-box" onclick="document.getElementById('p1').click()">
                            <div class="photo-icon">📷</div>
                            <img id="prev_p1" class="photo-preview">
                            <input type="file" id="p1" class="photo-input" accept="image/*" onchange="previewPhoto(1, event)">
                        </div>
                        <div class="photo-box" onclick="document.getElementById('p2').click()">
                            <div class="photo-icon">📷</div>
                            <img id="prev_p2" class="photo-preview">
                            <input type="file" id="p2" class="photo-input" accept="image/*" onchange="previewPhoto(2, event)">
                        </div>
                        <div class="photo-box" onclick="document.getElementById('p3').click()">
                            <div class="photo-icon">📷</div>
                            <img id="prev_p3" class="photo-preview">
                            <input type="file" id="p3" class="photo-input" accept="image/*" onchange="previewPhoto(3, event)">
                        </div>
                        <div class="photo-box" onclick="document.getElementById('p4').click()">
                            <div class="photo-icon">📷</div>
                            <img id="prev_p4" class="photo-preview">
                            <input type="file" id="p4" class="photo-input" accept="image/*" onchange="previewPhoto(4, event)">
                        </div>
                    </div>

                    <button type="submit" class="btn-save">Simpan Kendaraan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- PREVIEW IMAGE -->
    <div class="preview-modal" id="previewModal">
        <div class="close-preview" onclick="document.getElementById('previewModal').classList.remove('open')">&times;</div>
        <img id="previewImg" src="" class="preview-img">
    </div>

    <script>
        // --- DATA DUMMY ---
        const dummyVehicles = [
            { id: 1, plate: "B 1983 TUA", brand: "Toyota", model: "Innova Reborn", year: 2020, type: "MPV", user: "Bagian Umum", legal: { exp_m: 12, exp_y: 2024 }, summary: { total: 8, cost: 5000000 } },
            { id: 2, plate: "B 9881 PAH", brand: "Toyota", model: "Hilux Double Cabin", year: 2019, type: "Pick Up", user: "Operasional", legal: { exp_m: 6, exp_y: 2024 }, summary: { total: 12, cost: 12500000 } }
        ];
        let vehicles = JSON.parse(localStorage.getItem('vehicleData')) || dummyVehicles;
        let tempPhotos = ["", "", "", ""];

        // --- UTILS ---
        function saveData() { localStorage.setItem('vehicleData', JSON.stringify(vehicles)); }
        function formatRupiah(n) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n); }
        function getStnkStatus(m, y) {
            const d = new Date(y, m - 1);
            const n = new Date();
            const diff = (d.getFullYear() - n.getFullYear()) * 12 + (d.getMonth() - n.getMonth());
            return diff < 0 ? { text: 'Expired', class: 'status-expired' } : (diff < 3 ? { text: 'Hampir Habis', class: 'status-warning' } : { text: 'Aktif', class: 'status-active' });
        }

        // --- RENDER BERANDA ---
        function renderTable() {
            const tbody = document.getElementById('vehicleTable');
            const filter = document.querySelector('.search-filter-group select:last-child').value;
            const search = document.querySelector('input[type="text"]').value.toLowerCase();
            tbody.innerHTML = '';

            vehicles.forEach(v => {
                if (filter && v.type !== filter) return;
                if (search && !v.plate.toLowerCase().includes(search)) return;

                const stnk = getStnkStatus(v.legal.exp_m, v.legal.exp_y);
                tbody.innerHTML += `
                    <tr>
                        <td>
                            <div class="badge-plate">${v.plate}</div>
                            <div style="font-weight:600; font-size: 0.9rem;">${v.brand}</div>
                        </td>
                        <td>${v.type} / ${v.model}</td>
                        <td>${v.user}</td>
                        <td><span class="status-badge ${stnk.class}">${stnk.text}</span></td>
                        <td style="text-align: right;">
                            <button class="btn-sm" onclick="alert('Detail fitur (Dummy)')">Detail</button>
                        </td>
                    </tr>
                `;
            });
        }

        // --- SWITCH VIEW ---
        function switchMainView(view) {
            document.querySelectorAll('[id^="view-"]').forEach(el => el.style.display = 'none');
            document.getElementById('view-' + view).style.display = 'block';
            if(view === 'laporan') generateReport();
            if(view === 'identitas') generateIdentityStats();
        }

        function generateReport() {
            const tbody = document.getElementById('reportBody');
            tbody.innerHTML = '';
            vehicles.forEach(v => {
                tbody.innerHTML += `
                    <tr>
                        <td>${v.plate} - ${v.brand}</td>
                        <td>${v.summary.total} Kali</td>
                        <td>${formatRupiah(v.summary.cost)}</td>
                    </tr>
                `;
            });
        }

        function generateIdentityStats() {
            document.getElementById('id-total-veh').innerText = vehicles.length;
            let exp = 0, ready = 0;
            vehicles.forEach(v => {
                const stnk = getStnkStatus(v.legal.exp_m, v.legal.exp_y);
                if (stnk.text === 'Expired') exp++;
                if (stnk.text === 'Aktif') ready++;
            });
            document.getElementById('id-total-exp').innerText = exp;
            document.getElementById('id-total-ready').innerText = ready;
        }

        // --- MODAL ADD LOGIC ---
        function openAddModal() {
            document.getElementById('addModal').classList.add('open');
            document.querySelector('#addModal form').reset();
            tempPhotos = ["", "", "", ""];
            for(let i=1; i<=4; i++) {
                document.getElementById(`prev_p${i}`).src = "";
                document.getElementById(`prev_p${i}`).classList.remove('show');
            }
        }
        function closeAddModal() { document.getElementById('addModal').classList.remove('open'); }
        
        function previewPhoto(idx, e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    tempPhotos[idx-1] = e.target.result;
                    document.getElementById(`prev_p${idx}`).src = e.target.result;
                    document.getElementById(`prev_p${idx}`).classList.add('show');
                }
                reader.readAsDataURL(file);
            }
        }

        function handleAdd(e) {
            e.preventDefault();
            const newV = {
                id: vehicles.length + 1,
                plate: document.getElementById('f_plate').value,
                brand: document.getElementById('f_brand').value,
                model: document.getElementById('f_model').value,
                type: document.getElementById('f_type').value,
                year: document.getElementById('f_year').value,
                user: document.getElementById('f_user').value,
                legal: {
                    exp_m: document.getElementById('f_exp_m').value,
                    exp_y: document.getElementById('f_exp_y').value
                },
                summary: { total: 0, cost: 0 },
                gallery: tempPhotos.length > 0 ? tempPhotos : ["https://picsum.photos/seed/newcar/600/400"]
            };
            vehicles.unshift(newV);
            saveData();
            closeAddModal();
            renderTable();
            alert('Data berhasil disimpan (LocalStorage)');
        }

        function switchTab(id) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }

        function closeDetailModal() { document.getElementById('detailModal').classList.remove('open'); }
        
        // Init
        renderTable();
    </script>
</body>
</html>