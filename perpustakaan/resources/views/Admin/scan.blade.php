<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner QR | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --accent: #4cc9f0;
            --dark-sidebar: #1e1e2d;
            --bg-light: #f4f7fe;
            --text-muted: #7e8299;
        }

        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; color: #2b2b40; }

        /* SIDEBAR (Sama dengan Dashboard) */
        .sidebar { height: 100vh; background: var(--dark-sidebar); color: #fff; position: fixed; width: 16.66667%; z-index: 100; }
        .sidebar-header { padding: 30px 25px; background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .sidebar-brand { font-weight: 700; font-size: 1.25rem; color: white; text-decoration: none; display: block; }
        .sidebar-brand span { color: var(--accent); }
        .sidebar-menu { padding: 20px; }
        .sidebar a { color: #a2a3b7; display: flex; align-items: center; padding: 14px 18px; text-decoration: none; transition: 0.3s; border-radius: 12px; margin-bottom: 8px; font-size: 0.9rem; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3); }
        .sidebar-icon { margin-right: 12px; font-size: 1.1rem; }

        /* MAIN CONTENT */
        .main-content { margin-left: 16.66667%; padding: 40px; }
        .page-header { font-weight: 800; color: var(--dark-sidebar); letter-spacing: -1px; margin-bottom: 30px; }

        /* SCANNER BOX */
        .scanner-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: none; }
        #reader { width: 100%; border-radius: 15px; overflow: hidden; border: none !important; background: #f8fafc; }
        
        .result-card { background: white; border-radius: 24px; padding: 30px; display: none; border-left: 6px solid var(--primary); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .info-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
        .info-value { font-size: 1rem; font-weight: 600; color: var(--dark-sidebar); margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar d-none d-md-block">
            <div class="sidebar-header text-center">
                <a href="#" class="sidebar-brand">Treasure<span>Library</span></a>
            </div>
            <div class="sidebar-menu">
                <small class="text-uppercase fw-bold text-muted mb-3 d-block" style="font-size: 0.65rem; letter-spacing: 2px; padding-left: 15px;">Main Menu</small>
                <nav>
                    <a href="/admin/dashboard" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><span class="sidebar-icon">🏠</span> Dashboard</a>
                    <a href="/admin/user"><span class="sidebar-icon">👥</span> Data Anggota</a>
                    <a href="/admin/buku"><span class="sidebar-icon">📚</span> Koleksi Buku</a>
                    <a href="{{ route('admin.scan') }}" class="{{ Request::is('admin/scan') ? 'active' : '' }}"><span class="sidebar-icon">📸</span> Scan Peminjaman</a>
                    <a href="#"><span class="sidebar-icon">🔄</span> Sirkulasi</a>
                    <a href="#"><span class="sidebar-icon">📊</span> Laporan</a>
                </nav>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <h2 class="page-header">Scan QR Peminjaman</h2>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="scanner-card text-center">
                        <div id="reader"></div>
                        <p class="text-muted small mt-3">Arahkan kamera ke QR Code Peminjam</p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div id="result-card" class="result-card">
                        <h4 class="fw-bold mb-4 text-primary">Konfirmasi Data Pinjam</h4>
                        <form action="{{ route('admin.proses.pinjam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payload" id="raw_payload">
                            
                            <div class="mb-3">
                                <span class="info-label">Detail User & Buku</span>
                                <div class="info-value" id="display-data">Menunggu scan...</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow">
                                VALIDASI SEKARANG
                            </button>
                            <button type="button" onclick="location.reload()" class="btn btn-light w-100 mt-2 rounded-4 text-muted">Scan Ulang</button>
                        </form>
                    </div>

                    <div id="placeholder-card" class="scanner-card d-flex align-items-center justify-content-center text-center" style="min-height: 300px; border: 2px dashed #cbd5e0; background: transparent;">
                        <div class="text-muted">
                            <div style="font-size: 3rem;">📸</div>
                            <p class="fw-bold">Kamera siap, silakan scan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        html5QrcodeScanner.clear();
        document.getElementById('placeholder-card').style.display = 'none';
        document.getElementById('result-card').style.display = 'block';
        document.getElementById('raw_payload').value = decodedText;
        document.getElementById('display-data').innerText = decodedText;
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: {width: 250, height: 250} }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>