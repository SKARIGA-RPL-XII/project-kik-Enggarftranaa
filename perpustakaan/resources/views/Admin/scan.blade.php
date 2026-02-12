<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Terminal | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { 
            --primary: #4e60ff; 
            --primary-glow: rgba(78, 96, 255, 0.35);
            --dark-sidebar: #111827; 
            --bg-light: #f8fafc; 
            --danger: #ef4444; 
            --sidebar-width: 280px;
            --sidebar-mini-width: 100px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR SYSTEM (Sesuai Halaman Kategori) --- */
        .sidebar { 
            height: 100vh; background: var(--dark-sidebar); color: #fff; 
            position: fixed; width: var(--sidebar-width); z-index: 1000;
            padding: 30px 20px; display: flex; flex-direction: column;
            transition: var(--transition); overflow: hidden;
        }
        body.sidebar-mini .sidebar { width: var(--sidebar-mini-width); padding: 30px 15px; }

        .sidebar-brand {
            font-weight: 800; font-size: 1.2rem; color: white; text-decoration: none;
            display: flex; align-items: center; padding: 10px; margin-bottom: 40px; gap: 12px;
        }
        .brand-logo-box {
            width: 45px; height: 45px; background: var(--primary); border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;
        }
        body.sidebar-mini .sidebar-brand span:not(.brand-logo-box) { display: none; }

        .sidebar-category {
            font-size: 0.7rem; font-weight: 800; color: #4b5563; text-transform: uppercase;
            letter-spacing: 1.5px; margin: 25px 0 12px 15px; white-space: nowrap;
        }
        body.sidebar-mini .sidebar-category { display: none; }

        .sidebar a { 
            color: #94a3b8; display: flex; align-items: center; padding: 16px; 
            text-decoration: none; border-radius: 18px; margin-bottom: 8px; 
            font-size: 0.95rem; font-weight: 600; transition: var(--transition);
        }
        .sidebar a:hover { color: #fff; background: rgba(255,255,255,0.03); }
        .sidebar a.active { background: var(--primary); color: white; box-shadow: 0 10px 25px -5px var(--primary-glow); }

        .sidebar-icon { min-width: 35px; font-size: 1.3rem; display: flex; justify-content: center; align-items: center; margin-right: 15px; }
        body.sidebar-mini .sidebar-icon { margin-right: 0; min-width: 100%; }
        body.sidebar-mini .sidebar a span:not(.sidebar-icon) { display: none; }

        /* --- LAYOUT & CONTENT --- */
        .top-navbar {
            position: fixed; top: 0; right: 0; left: var(--sidebar-width);
            height: 85px; background: rgba(248, 250, 252, 0.9); backdrop-filter: blur(10px);
            display: flex; align-items: center; padding: 0 40px; z-index: 999;
            transition: var(--transition); border-bottom: 1px solid #eef2f6;
        }
        body.sidebar-mini .top-navbar { left: var(--sidebar-mini-width); }

        .main-content { margin-left: var(--sidebar-width); padding: 125px 40px 40px; transition: var(--transition); }
        body.sidebar-mini .main-content { margin-left: var(--sidebar-mini-width); }

        .sidebar-toggle { background: white; border: 1px solid #e2e8f0; width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }

        /* SCANNER UI */
        .scanner-wrapper {
            background: white; padding: 20px; border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;
        }
        #reader { width: 100% !important; border: none !important; border-radius: 20px; overflow: hidden; }

        /* RESULT CARD */
        .result-card {
            background: white; border-radius: 35px; padding: 45px; display: none;
            border: 1px solid #e2e8f0; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08);
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        .section-tag { font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; display: block; }
        .info-pill { background: #f8fafc; border-radius: 20px; padding: 20px; border: 1px solid #f1f5f9; }
        .book-detail-box { display: flex; align-items: center; padding: 20px; background: #fcfcfd; border: 1px solid #e2e8f0; border-radius: 24px; }

        .btn-action {
            background: var(--dark-sidebar); color: white; border: none; border-radius: 18px;
            padding: 22px; font-weight: 800; width: 100%; transition: 0.3s; text-transform: uppercase;
        }
        .btn-action:hover { background: var(--primary); transform: translateY(-3px); box-shadow: 0 15px 30px var(--primary-glow); }

        #placeholder-ui {
            min-height: 500px; border: 3px dashed #e2e8f0; border-radius: 40px;
            display: flex; align-items: center; justify-content: center; background: rgba(248, 250, 252, 0.5);
        }
        .avatar-frame { width: 80px; height: 80px; border-radius: 20px; object-fit: cover; border: 4px solid white; box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="">

<aside class="sidebar">
    <a href="#" class="sidebar-brand">
        <span class="brand-logo-box"><i class="fa-solid fa-record-vinyl"></i></span>
        <span>TREASURE<span style="color:var(--primary)">LIB</span></span>
    </a>

    <div class="sidebar-menu">
        <div class="sidebar-category">Analytics</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Dashboard</span>
            </a>
        </nav>

        <div class="sidebar-category">Management</div>
        <nav>
            <a href="/admin/user">
                <span class="sidebar-icon"><i class="fa-solid fa-users-viewfinder"></i></span>
                <span>Data Anggota</span>
            </a>
            <a href="{{ route('admin.buku.index') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-book"></i></span>
                <span>Koleksi Buku</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-layer-group"></i></span>
                <span>Kelola Kategori</span>
            </a>
        </nav>

        <div class="sidebar-category">Operation</div>
        <nav>
            <a href="{{ route('admin.scan') }}" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span>
                <span>Scan Pinjam</span>
            </a>
            <a href="{{ route('admin.peminjaman.index') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                <span>Riwayat</span>
            </a>
        </nav>
    </div>
</aside>

<nav class="top-navbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="ms-4 fw-700 text-muted d-none d-md-block">
        Admin Panel <span class="mx-2 text-light-emphasis">/</span> <span class="text-dark fw-800">Scan Pinjam</span>
    </div>
</nav>

<main class="main-content">
    <header class="mb-5">
        <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px; font-size: 2rem;">Terminal Peminjaman</h2>
        <p class="text-muted fw-500">Otentikasi QR Code untuk memproses peminjaman buku.</p>
    </header>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="scanner-wrapper">
                <div id="reader"></div>
            </div>
            <div class="mt-4 p-3 bg-white rounded-4 border shadow-sm d-flex align-items-center">
                <div class="bg-light p-2 rounded-3 me-3 text-primary">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <p class="small mb-0 text-muted fw-600">Scan QR Code peminjaman dari aplikasi user.</p>
            </div>
        </div>

        <div class="col-lg-7">
            <div id="placeholder-ui">
                <div class="text-center">
                    <i class="fa-solid fa-qrcode fa-4x mb-4 opacity-25"></i>
                    <p class="fw-800 text-muted mb-0">MENUNGGU SINYAL DATA</p>
                </div>
            </div>

            <div id="result-card" class="result-card">
                <span class="section-tag">Verifikasi Berhasil</span>
                
                <div class="d-flex align-items-center mb-4">
                    <img src="" id="res-foto" class="avatar-frame me-4 bg-light" onerror="this.src='https://ui-avatars.com/api/?name=User&background=4e60ff&color=fff'">
                    <div>
                        <div class="fw-800 fs-4" id="res-nama">Member Fullname</div>
                        <div class="text-muted fw-600" id="res-email">member@library.com</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-pill">
                            <span class="section-tag" style="font-size: 0.6rem; margin-bottom: 5px;">Member Identity</span>
                            <div class="fw-800 text-primary fs-5" id="res-id">#ID-00000</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-pill">
                            <span class="section-tag" style="font-size: 0.6rem; margin-bottom: 5px;">Deadline Target</span>
                            <div class="fw-800 text-danger fs-5" id="res-tgl-kembali">--/--/--</div>
                        </div>
                    </div>
                </div>

                <span class="section-tag">Asset Recognition</span>
                <div class="book-detail-box mb-4">
                    <img src="" id="res-buku-cover" class="rounded-3 me-4 shadow" style="width: 60px; height: 85px; object-fit: cover;">
                    <div>
                        <div class="fw-800 mb-1" id="res-buku-judul" style="font-size: 1.1rem;">Detected Book Title</div>
                        <code class="bg-white border px-2 py-1 rounded text-primary fw-bold" id="res-buku-kode">CODE: --</code>
                    </div>
                </div>

                <form action="{{ route('admin.proses.pinjam') }}" method="POST" id="transactionForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id_input">
                    <input type="hidden" name="buku_id" id="buku_id_input">
                    <input type="hidden" name="tgl_kembali" id="tgl_kembali_input">
                    
                    <button type="submit" class="btn-action shadow-lg" id="submitBtn">KONFIRMASI PINJAM</button>
                    <button type="button" onclick="window.location.reload()" class="btn btn-link w-100 mt-2 text-muted text-decoration-none fw-bold small opacity-50">BATALKAN PROSES</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function toggleSidebar() { document.body.classList.toggle('sidebar-mini'); }

    function onScanSuccess(decodedText) {
        html5QrcodeScanner.clear();
        let cleanText = decodeURIComponent(decodedText).trim();
        const parts = cleanText.split('|');
        let rawData = {};
        parts.forEach(p => {
            let item = p.split(':');
            if(item.length >= 2) rawData[item[0].trim()] = item[1].trim();
        });

        if(!rawData.USER_ID || !rawData.BUKU_ID) {
            alert("Format QR tidak valid!");
            window.location.reload();
            return;
        }

        fetch(`/admin/get-peminjam/${rawData.USER_ID}/${rawData.BUKU_ID}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('placeholder-ui').style.display = 'none';
                    document.getElementById('result-card').style.display = 'block';
                    document.getElementById('res-nama').innerText = data.user.nama;
                    document.getElementById('res-email').innerText = data.user.email;
                    document.getElementById('res-foto').src = data.user.foto;
                    document.getElementById('res-id').innerText = "#ID-" + data.user.id_asli;
                    document.getElementById('res-tgl-kembali').innerText = rawData.KEMBALI || 'N/A';
                    document.getElementById('res-buku-judul').innerText = data.buku.judul;
                    document.getElementById('res-buku-kode').innerText = "CODE: " + data.buku.kode;
                    document.getElementById('res-buku-cover').src = data.buku.cover_url;
                    
                    document.getElementById('user_id_input').value = data.user.id_asli;
                    document.getElementById('buku_id_input').value = data.buku.id;
                    document.getElementById('tgl_kembali_input').value = rawData.KEMBALI || '';
                } else {
                    alert(data.message);
                    window.location.reload();
                }
            })
            .catch(err => {
                alert("Gagal mengambil data transaksi.");
                window.location.reload();
            });
    }

    document.getElementById('transactionForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> PROCESSING...';
        btn.disabled = true;
    });

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 25, 
        qrbox: {width: 280, height: 280}
    });
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>