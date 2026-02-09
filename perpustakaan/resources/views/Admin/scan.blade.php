<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Terminal | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #1e40af;
            --brand-dark: #0f172a;
            --bg-body: #f1f5f9;
            --success: #10b981;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }

        .sidebar { 
            height: 100vh; 
            background: var(--brand-dark); 
            position: fixed; 
            width: 280px; 
            z-index: 1000; 
            padding: 40px 24px;
        }
        .sidebar-brand { 
            font-weight: 800; 
            font-size: 1.2rem; 
            color: white; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            margin-bottom: 48px;
            letter-spacing: -0.5px;
        }
        .sidebar-brand i { color: var(--success); margin-right: 12px; }
        
        .sidebar a { 
            color: #94a3b8; 
            display: flex; 
            align-items: center; 
            padding: 14px 16px; 
            text-decoration: none; 
            border-radius: 12px; 
            margin-bottom: 6px; 
            font-size: 0.95rem;
            font-weight: 600;
            transition: 0.2s;
        }
        .sidebar a i { width: 24px; font-size: 1.1rem; margin-right: 12px; opacity: 0.7; }
        .sidebar a:hover { color: white; background: rgba(255,255,255,0.05); }
        .sidebar a.active { background: var(--brand-primary); color: white; box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3); }

        .main-content { margin-left: 280px; padding: 60px; }
        
        .scanner-container {
            background: white;
            padding: 16px;
            border-radius: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        #reader { 
            width: 100% !important; 
            border: none !important; 
            border-radius: 16px;
            overflow: hidden;
        }

        .result-card {
            background: white;
            border-radius: 32px;
            padding: 40px;
            display: none;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 20px 50px rgba(0,0,0,0.04);
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            display: block;
        }

        .info-pill {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid #f1f5f9;
            height: 100%;
        }

        .user-meta {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brand-dark);
        }

        .book-detail-box {
            display: flex;
            align-items: center;
            padding: 24px;
            background: #fdfdfd;
            border: 2px solid #f1f5f9;
            border-radius: 24px;
        }

        .btn-action {
            background: var(--brand-dark);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 20px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-action:hover {
            background: var(--brand-primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 64, 175, 0.2);
        }

        #placeholder-ui {
            height: 100%;
            min-height: 400px;
            border: 2px dashed #cbd5e1;
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
        }

        .avatar-frame {
            width: 72px; height: 72px;
            border-radius: 20px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<aside class="sidebar d-none d-md-block">
    <a href="#" class="sidebar-brand">
        <i class="fa-solid fa-layer-group"></i> TREASURE<span>CORE</span>
    </a>
    <nav>
        <a href="/admin/dashboard"><i class="fa-solid fa-house-user"></i> Dashboard</a>
        <a href="/admin/user"><i class="fa-solid fa-address-book"></i> Members Registry</a>
        <a href="/admin/buku"><i class="fa-solid fa-book-open"></i> Archive</a>
        <a href="#" class="active"><i class="fa-solid fa-bolt-lightning"></i> Fast Scan</a>
    </nav>
</aside>

<main class="main-content">
    <header class="mb-5">
        <h1 class="fw-800" style="letter-spacing: -1px; font-size: 2.2rem;">Loan Processing</h1>
        <p class="text-muted fw-500">Secure resource allocation via QR identification</p>
    </header>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="scanner-container">
                <div id="reader"></div>
            </div>
            <div class="mt-4 p-3 bg-white rounded-4 border-start border-primary border-4">
                <p class="small mb-0 text-muted fw-600">
                    <i class="fa-solid fa-circle-info me-2 text-primary"></i> 
                    Scan QR Code untuk verifikasi data peminjaman.
                </p>
            </div>
        </div>

        <div class="col-lg-7">
            <div id="placeholder-ui">
                <div class="text-center">
                    <i class="fa-solid fa-qrcode fa-3x mb-3 opacity-25"></i>
                    <p class="fw-700">Awaiting Signal Data</p>
                </div>
            </div>

            <div id="result-card" class="result-card">
                <span class="section-title">Verification Successful</span>
                
                <div class="d-flex align-items-center mb-5">
                    <img src="" id="res-foto" class="avatar-frame me-4 bg-light" onerror="this.src='https://ui-avatars.com/api/?name=User'">
                    <div>
                        <div class="user-meta" id="res-nama">Member Fullname</div>
                        <div class="text-muted fw-600 small" id="res-email">member@library.com</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-pill">
                            <span class="section-title" style="margin-bottom: 5px;">Member ID</span>
                            <div class="fw-800 text-primary" id="res-id">#ID-00000</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-pill">
                            <span class="section-title" style="margin-bottom: 5px;">Tanggal Pengembalian</span>
                            <div class="fw-800 text-danger" id="res-tgl-kembali">--/--/--</div>
                        </div>
                    </div>
                </div>

                <span class="section-title">Asset Recognition</span>
                <div class="book-detail-box mb-5">
                    <img src="" id="res-buku-cover" class="rounded-3 me-4 shadow-sm" style="width: 55px; height: 80px; object-fit: cover;">
                    <div>
                        <div class="fw-800 mb-1" id="res-buku-judul" style="font-size: 1.1rem;">Detected Book Title</div>
                        <code class="bg-light px-2 py-1 rounded text-dark" id="res-buku-kode">CODE: --</code>
                    </div>
                </div>

                <form action="{{ route('admin.proses.pinjam') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id_input">
                    <input type="hidden" name="buku_id" id="buku_id_input">
                    <input type="hidden" name="tgl_kembali" id="tgl_kembali_input">
                    <input type="hidden" name="payload" id="payload_input">
                    
                    <button type="submit" class="btn-action shadow">COMMIT TRANSACTION</button>
                    <button type="button" onclick="location.reload()" class="btn btn-link w-100 mt-3 text-muted text-decoration-none fw-700 small">ABORT PROCESS</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText) {
        // Hentikan scanner agar tidak double process
        html5QrcodeScanner.clear();
        
        let cleanText = decodeURIComponent(decodedText).trim();
        console.log("Raw Data:", cleanText);

        // Memecah format USER_ID:1|BUKU_ID:5|KEMBALI:2026-02-07
        const parts = cleanText.split('|');
        let rawData = {};
        parts.forEach(p => {
            let item = p.split(':');
            if(item.length >= 2) {
                rawData[item[0].trim()] = item[1].trim();
            }
        });

        // Validasi data minimal
        if(!rawData.USER_ID || !rawData.BUKU_ID) {
            alert("Format QR tidak dikenali! Gunakan tiket terbaru.");
            location.reload();
            return;
        }

        // Panggil Controller Admin
        fetch(`/admin/get-peminjam/${rawData.USER_ID}/${rawData.BUKU_ID}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // TETAPKAN DESIGN KAMU: Sembunyikan placeholder, munculkan result
                    document.getElementById('placeholder-ui').style.display = 'none';
                    document.getElementById('result-card').style.display = 'block';
                    
                    // Isi data ke elemen desain kamu
                    document.getElementById('res-nama').innerText = data.user.nama;
                    document.getElementById('res-email').innerText = data.user.email;
                    document.getElementById('res-foto').src = data.user.foto;
                    document.getElementById('res-id').innerText = "#ID-" + data.user.id_asli;
                    
                    document.getElementById('res-tgl-kembali').innerText = rawData.KEMBALI || 'N/A';
                    document.getElementById('tgl_kembali_input').value = rawData.KEMBALI || '';
                    
                    document.getElementById('res-buku-judul').innerText = data.buku.judul;
                    document.getElementById('res-buku-kode').innerText = "CODE: " + data.buku.kode;
                    document.getElementById('res-buku-cover').src = data.buku.cover_url;
                    
                    document.getElementById('user_id_input').value = data.user.id_asli;
                    document.getElementById('buku_id_input').value = data.buku.id;
                    document.getElementById('payload_input').value = cleanText;
                } else {
                    alert("Gagal: " + data.message);
                    location.reload();
                }
            })
            .catch(err => {
                console.error(err);
                alert("Gagal memproses data. Cek koneksi atau Controller.");
                location.reload();
            });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 20, 
        qrbox: {width: 250, height: 250}
    });
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>