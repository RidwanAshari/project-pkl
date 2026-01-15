<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Aset - Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; }

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
        
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }

        /* DASHBOARD CONTENT */
        .content-body { padding: 2rem; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .page-title h2 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); }
        .page-title p { color: var(--text-muted); font-size: 0.9rem; margin-top: 4px; }
        
        .btn-add {
            background: var(--primary); color: white; border: none; padding: 10px 20px;
            border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2); transition: 0.2s;
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
        
        .stat-info h4 { font-size: 0.85rem; color: var(--text-muted); font-weight: 500; }
        .stat-info p { font-size: 1.5rem; font-weight: 700; margin-top: 2px; }

        /* TABLE STYLES */
        .table-container {
            background: var(--bg-card); border-radius: var(--radius); box-shadow: var(--shadow-md);
            overflow: hidden; border: 1px solid var(--border);
        }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th {
            background: #f9fafb; padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600;
            text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; border-bottom: 1px solid var(--border);
        }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); font-size: 0.9rem; color: var(--text-main); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f9fafb; }

        /* BADGES */
        .status-pill {
            padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: capitalize;
        }
        .pill-baik { background: #d1fae5; color: #065f46; }
        .pill-perbaikan { background: #ffedd5; color: #9a3412; }
        .pill-rusak { background: #fee2e2; color: #991b1b; }
        .pill-dipinjam { background: #dbeafe; color: #1e40af; } /* Baru untuk peminjaman */

        .action-btn {
            padding: 6px 12px; border-radius: 6px; border: 1px solid var(--border); background: white;
            cursor: pointer; font-size: 0.8rem; margin-right: 4px; transition: 0.2s;
        }
        .action-btn:hover { background: #f3f4f6; border-color: #d1d5db; }
        .btn-edit { color: var(--primary); }
        .btn-delete { color: var(--danger); }

        /* MODAL FORM */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4);
            display: flex; justify-content: center; align-items: center; z-index: 100;
            opacity: 0; visibility: hidden; transition: 0.3s; backdrop-filter: blur(4px);
        }
        .modal-overlay.open { opacity: 1; visibility: visible; }
        .modal {
            background: white; width: 500px; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-md);
            transform: scale(0.95); transition: 0.3s; max-height: 90vh; overflow-y: auto;
        }
        .modal-overlay.open .modal { transform: scale(1); }
        .modal-header { display: flex; justify-content: space-between; margin-bottom: 1.5rem; }
        .modal-title { font-size: 1.25rem; font-weight: 700; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; outline: none; transition: 0.2s;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 2px #e0e7ff; }
        .full { grid-column: span 2; }

        /* CSS UNTUK TOMBOL UPLOAD FOTO */
        input[type="file"]::file-selector-button {
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            background: var(--primary);
            color: white;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-save {
            width: 100%; background: var(--primary); color: white; padding: 12px; border-radius: 8px;
            border: none; font-weight: 600; cursor: pointer; margin-top: 1rem;
        }
        .btn-cancel {
            position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);
        }

        /* MODAL DETAIL (FOTO & HISTORY) */
        .modal-detail { width: 800px; max-width: 95%; }
        .detail-content { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .detail-left { border-right: 1px solid var(--border); padding-right: 1.5rem; }
        .photo-container {
            width: 100%; height: 200px; background: #f3f4f6; border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem; border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
        }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }
        .spec-item { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem; }
        .spec-item span.label { color: var(--text-muted); }
        
        .detail-right { padding-left: 0.5rem; max-height: 350px; overflow-y: auto; }
        .history-list { display: flex; flex-direction: column; gap: 1rem; }
        .history-item { background: #f9fafb; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border); }
        .h-user { font-weight: 600; color: var(--text-main); font-size: 0.9rem; }
        .h-info { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }

        /* TOAST */
        .toast {
            position: fixed; bottom: 20px; right: 20px; background: white; padding: 12px 20px;
            border-radius: 8px; box-shadow: var(--shadow-md); border-left: 4px solid var(--success);
            transform: translateY(100px); transition: 0.3s; z-index: 200; display: flex; align-items: center; gap: 10px;
        }
        .toast.show { transform: translateY(0); }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="logo-area">
            <div class="logo-icon">A</div>
            <div class="logo-text">Asset<span style="color:var(--primary)">Flow</span></div>
        </div>
        <div class="nav-menu">
            <a href="/dashboard" class="nav-item">🏠 Dashboard</a>
            <a href="/data-aset" class="nav-item active">📊 Data Aset</a>
            <a href="/history" class="nav-item">📅 History Peminjaman</a>
            <a href="/kategori" class="nav-item">📂 Kategori</a>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="search-bar">
                <span>🔍</span>
                <input type="text" id="searchInput" placeholder="Cari aset..." onkeyup="filterAssets()">
            </div>
            <div class="user-profile">
                <div style="text-align: right;">
                    <div style="font-weight: 600; font-size: 0.9rem;">Administrator</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">IT Dept</div>
                </div>
                <img src="https://picsum.photos/seed/admin/100/100" alt="Avatar" class="user-avatar">
            </div>
        </header>

        <!-- Body -->
        <div class="content-body">
            
            <!-- Title & Action -->
            <div class="page-header">
                <div class="page-title">
                    <h2>Daftar Inventaris</h2>
                    <p>Kelola seluruh data aset perusahaan Anda di sini.</p>
                </div>
                <button class="btn-add" onclick="openModal()">
                    <span>+</span> Tambah Aset
                </button>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon icon-blue">📦</div>
                    <div class="stat-info">
                        <h4>Total Aset</h4>
                        <p id="totalItems">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-green">💰</div>
                    <div class="stat-info">
                        <h4>Nilai Total</h4>
                        <p id="totalValue" style="font-size: 1.1rem; margin-top: 6px;">Rp 0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-orange">🔧</div>
                    <div class="stat-info">
                        <h4>Perlu Maintenance</h4>
                        <p id="totalRepair">0</p>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Peminjam</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data Loaded by JS -->
                    </tbody>
                </table>
                <div id="emptyState" style="text-align: center; padding: 3rem; color: var(--text-muted); display: none;">
                    Belum ada data.
                </div>
            </div>

        </div>
    </main>

    <!-- MODAL FORM (TAMBAH/EDIT) -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <button class="btn-cancel" onclick="closeModal()">&times;</button>
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Tambah Aset</h3>
            </div>
            <form id="assetForm" onsubmit="handleFormSubmit(event)">
                <input type="hidden" id="assetId">
                
                <!-- Input Foto -->
                <div class="form-group full">
                    <label>Foto Barang</label>
                    <input type="file" id="assetPhotoInput" accept="image/*" class="form-input" onchange="previewImage(event)">
                    <div id="previewContainer" style="margin-top: 10px; display: none;">
                        <img id="imagePreview" src="" alt="Preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                        <button type="button" onclick="clearImage()" style="display:block; margin-top:5px; font-size:0.8rem; color:var(--danger); background:none; border:none; cursor:pointer;">Hapus Foto</button>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full">
                        <label>Nama Aset</label>
                        <input type="text" id="assetName" class="form-input" required placeholder="Contoh: Macbook Pro M2">
                    </div>
                    <div class="form-group">
                        <label>Kode Aset</label>
                        <input type="text" id="assetCode" class="form-input" required placeholder="AST-001">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="assetCategory" class="form-input">
                            <option value="Elektronik">Elektronik</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Kendaraan">Kendaraan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" id="assetPrice" class="form-input" required min="0">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="assetStatus" class="form-input">
                            <option value="Baik">Baik</option>
                            <option value="Perbaikan">Perbaikan</option>
                            <option value="Rusak">Rusak</option>
                            <option value="Dipinjam">Dipinjam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Beli</label>
                        <input type="date" id="assetDate" class="form-input" required>
                    </div>
                </div>

                <!-- Input Peminjam -->
                <div class="form-group full">
                    <label>Saat Ini Dipinjam Oleh (Opsional)</label>
                    <input type="text" id="assetBorrower" class="form-input" placeholder="Ketik nama pegawai jika dipinjam">
                </div>

                <button type="submit" class="btn-save">Simpan Data Aset</button>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL (FOTO & HISTORY) -->
    <div class="modal-overlay" id="detailOverlay">
        <div class="modal modal-detail">
            <button class="btn-cancel" onclick="closeDetail()">&times;</button>
            <div class="modal-header">
                <h3 class="modal-title">Detail Aset & Riwayat</h3>
            </div>
            
            <div class="detail-content">
                <!-- KOLOM KIRI: FOTO & SPEK -->
                <div class="detail-left">
                    <div class="photo-container">
                        <img id="detailPhoto" src="" alt="Foto Barang">
                    </div>
                    <div class="detail-specs">
                        <h4 id="detailName">Nama Barang</h4>
                        <p id="detailCode" style="color:var(--text-muted); margin-bottom:1rem;">Kode: AST-001</p>
                        
                        <div class="spec-item">
                            <span class="label">Kategori</span>
                            <span id="detailCategory">Elektronik</span>
                        </div>
                        <div class="spec-item">
                            <span class="label">Harga</span>
                            <span id="detailPrice">Rp 0</span>
                        </div>
                        <div class="spec-item">
                            <span class="label">Peminjam</span>
                            <span id="detailBorrower">-</span>
                        </div>
                        <div class="spec-item">
                            <span class="label">Status</span>
                            <span id="detailStatus" class="status-pill pill-baik">Baik</span>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: RIWAYAT PENGGUNAAN -->
                <div class="detail-right">
                    <h4 style="margin-bottom: 1rem; padding-bottom:0.5rem; border-bottom:1px solid var(--border);">Riwayat Penggunaan</h4>
                    <div class="history-list" id="historyList">
                        <!-- Log muncul di sini via JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast" id="toast">
        <span>✅</span>
        <span id="toastMessage">Berhasil disimpan!</span>
    </div>

    <!-- JAVASCRIPT LOGIC (LENGKAP) -->
    <script>
        
        // --- 1. DATA & LOCALSTORAGE ---
        let assets = JSON.parse(localStorage.getItem('inventoryData')) || [
            { id: 1, code: 'AST-001', name: 'MacBook Pro M2', category: 'Elektronik', purchase_date: '2023-01-10', price: 25000000, status: 'Baik', borrower: '', photo: 'https://picsum.photos/seed/mac/300/300', logs: [] },
            { id: 2, code: 'AST-002', name: 'Kursi Ergonomis', category: 'Furniture', purchase_date: '2023-03-05', price: 8500000, status: 'Dipinjam', borrower: 'Budi Santoso', photo: 'https://picsum.photos/seed/chair/300/300', logs: [] },
            { id: 3, code: 'AST-003', name: 'Printer Epson L3210', category: 'Elektronik', purchase_date: '2022-11-01', price: 2100000, status: 'Perbaikan', borrower: '', photo: 'https://picsum.photos/seed/print/300/300', logs: [] }
        ];

        let currentPhotoBase64 = null; // Variabel sementara untuk foto

        function saveToLocal() {
            localStorage.setItem('inventoryData', JSON.stringify(assets));
        }

        // --- 2. FUNGSI GAMBAR (PREVIEW) ---
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentPhotoBase64 = e.target.result; // Simpan data foto
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        function clearImage() {
            document.getElementById('assetPhotoInput').value = "";
            document.getElementById('imagePreview').src = "";
            document.getElementById('previewContainer').style.display = 'none';
            currentPhotoBase64 = null;
        }

        // --- 3. FUNGSI UTILITAS ---
        const formatRupiah = (number) => { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number); };
        
        const showToast = (msg, type = 'success') => {
            const toast = document.getElementById('toast');
            document.getElementById('toastMessage').innerText = msg;
            toast.style.borderLeftColor = type === 'error' ? 'var(--danger)' : 'var(--success)';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        };

        const getStatusClass = (status) => {
            if(status === 'Baik') return 'pill-baik';
            if(status === 'Perbaikan') return 'pill-perbaikan';
            if(status === 'Dipinjam') return 'pill-dipinjam';
            return 'pill-rusak';
        };

        // --- 4. CORE LOGIC ---
        function loadAssets() {
            renderTable(assets);
            updateStats(assets);
        }

        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            const empty = document.getElementById('emptyState');
            tbody.innerHTML = '';

            if (data.length === 0) {
                empty.style.display = 'block';
                return;
            }
            empty.style.display = 'none';

            data.forEach(item => {
                const tr = document.createElement('tr');
                // Menampilkan peminjam di tabel
                const borrowerDisplay = item.borrower ? `<span style="font-weight:600; font-size:0.8rem; color:var(--primary);">${item.borrower}</span>` : '<span style="color:var(--text-muted)">-</span>';

                tr.innerHTML = `
                    <td><strong>${item.code}</strong></td>
                    <td>${item.name}</td>
                    <td><span style="background:#f3f4f6; padding:2px 8px; border-radius:4px; font-size:0.8rem;">${item.category}</span></td>
                    <td>${borrowerDisplay}</td>
                    <td><span class="status-pill ${getStatusClass(item.status)}">${item.status}</span></td>
                    <td style="text-align: right;">
                        <button class="action-btn" style="color:var(--primary)" onclick="openDetail(${item.id})">Detail</button>
                        <button class="action-btn btn-edit" onclick="editAsset(${item.id})">Edit</button>
                        <button class="action-btn btn-delete" onclick="deleteAsset(${item.id})">Hapus</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateStats(data) {
            document.getElementById('totalItems').innerText = data.length;
            const totalVal = data.reduce((sum, item) => sum + Number(item.price), 0);
            document.getElementById('totalValue').innerText = formatRupiah(totalVal);
            document.getElementById('totalRepair').innerText = data.filter(i => i.status === 'Perbaikan').length;
        }

        function handleFormSubmit(e) {
            e.preventDefault();
            const id = document.getElementById('assetId').value;

            const formData = {
                name: document.getElementById('assetName').value,
                code: document.getElementById('assetCode').value,
                category: document.getElementById('assetCategory').value,
                purchase_date: document.getElementById('assetDate').value,
                price: document.getElementById('assetPrice').value,
                status: document.getElementById('assetStatus').value,
                borrower: document.getElementById('assetBorrower').value,
                logs: []
            };

            // Logic Foto: Pilih mana yang dipakai
            if (currentPhotoBase64) {
                formData.photo = currentPhotoBase64;
            } else if (id) {
                const oldData = assets.find(a => a.id == id);
                formData.photo = oldData ? oldData.photo : `https://picsum.photos/seed/${formData.code}/300/300`;
            } else {
                formData.photo = `https://picsum.photos/seed/${formData.code}/300/300`;
            }

            if (id) {
                const index = assets.findIndex(a => a.id == id);
                if (index !== -1) {
                    assets[index] = { ...assets[index], ...formData };
                    showToast('Data berhasil diperbarui');
                }
            } else {
                const newId = assets.length > 0 ? Math.max(...assets.map(a => a.id)) + 1 : 1;
                assets.unshift({ id: newId, ...formData });
                showToast('Aset baru berhasil ditambahkan');
            }

            clearImage();
            document.getElementById('assetBorrower').value = '';
            saveToLocal();
            closeModal();
            loadAssets();
        }

        function deleteAsset(id) {
            if(!confirm('Yakin hapus data ini?')) return;
            assets = assets.filter(a => a.id !== id);
            saveToLocal();
            showToast('Data dihapus', 'error');
            loadAssets();
        }

        // --- 5. MODAL LOGIC ---
        function openModal() {
            document.getElementById('assetForm').reset();
            document.getElementById('assetId').value = '';
            clearImage();
            document.getElementById('modalTitle').innerText = 'Tambah Aset';
            document.getElementById('modalOverlay').classList.add('open');
        }

        function editAsset(id) {
            const item = assets.find(a => a.id === id);
            if(item) {
                document.getElementById('assetId').value = item.id;
                document.getElementById('assetName').value = item.name;
                document.getElementById('assetCode').value = item.code;
                document.getElementById('assetCategory').value = item.category;
                document.getElementById('assetDate').value = item.purchase_date;
                document.getElementById('assetPrice').value = item.price;
                document.getElementById('assetStatus').value = item.status;
                document.getElementById('assetBorrower').value = item.borrower || '';
                
                if(item.photo) {
                    document.getElementById('imagePreview').src = item.photo;
                    document.getElementById('previewContainer').style.display = 'block';
                    currentPhotoBase64 = null;
                }

                document.getElementById('modalTitle').innerText = 'Edit Aset';
                document.getElementById('modalOverlay').classList.add('open');
            }
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
        }

        function filterAssets() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        }

        document.getElementById('modalOverlay').addEventListener('click', (e) => {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        });

        // --- 6. DETAIL MODAL LOGIC ---
        function openDetail(id) {
            const asset = assets.find(a => a.id === id);
            if(!asset) return;

            document.getElementById('detailName').innerText = asset.name;
            document.getElementById('detailCode').innerText = `Kode: ${asset.code}`;
            document.getElementById('detailCategory').innerText = asset.category;
            document.getElementById('detailPrice').innerText = formatRupiah(asset.price);
            document.getElementById('detailBorrower').innerText = asset.borrower || '-';
            
            const statusEl = document.getElementById('detailStatus');
            statusEl.innerText = asset.status;
            statusEl.className = `status-pill ${getStatusClass(asset.status)}`;

            // Tampilkan Foto
            const photoUrl = asset.photo ? asset.photo : `https://picsum.photos/seed/${asset.code}/300/300`;
            document.getElementById('detailPhoto').src = photoUrl;

            // Isi Riwayat
            const historyList = document.getElementById('historyList');
            historyList.innerHTML = ''; 

            if (asset.logs && asset.logs.length > 0) {
                asset.logs.forEach(log => {
                    const item = document.createElement('div');
                    item.className = 'history-item';
                    const date = new Date(log.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                    item.innerHTML = `
                        <div class="h-user">👤 ${log.user_name}</div>
                        <div class="h-info"><span style="font-weight:600">${log.action}</span> pada ${date}</div>
                    `;
                    historyList.appendChild(item);
                });
            } else {
                historyList.innerHTML = '<div style="color:var(--text-muted); text-align:center; padding:1rem;">Belum ada riwayat penggunaan.</div>';
            }

            document.getElementById('detailOverlay').classList.add('open');
        }

        function closeDetail() {
            document.getElementById('detailOverlay').classList.remove('open');
        }

        window.addEventListener('DOMContentLoaded', loadAssets);

    </script>
</body>
</html>