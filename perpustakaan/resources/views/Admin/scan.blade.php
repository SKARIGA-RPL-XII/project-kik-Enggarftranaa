<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Terminal | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #4361ee;
            --brand-dark: #0f172a;
            --bg-body: #f8fafc;
            --sidebar-width: 280px;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar { 
            height: 100vh; 
            background: var(--brand-dark); 
            position: fixed; 
            width: var(--sidebar-width); 
            z-index: 1000; 
            padding: 40px 24px;
        }
        .sidebar-brand { 
            font-weight: 800; 
            font-size: 1.4rem; 
            color: white; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            margin-bottom: 50px;
        }
        .sidebar-brand i { color: var(--brand-primary); margin-right: 12px; }
        
        .sidebar a { 
            color: #94a3b8; 
            display: flex; 
            align-items: center; 
            padding: 14px 18px; 
            text-decoration: none; 
            border-radius: 14px; 
            margin-bottom: 8px; 
            font-weight: 600;
            transition: 0.3s;
        }
        .sidebar a:hover { color: white; background: rgba(255,255,255,0.03); transform: translateX(5px); }
        .sidebar a.active { background: var(--brand-primary); color: white; box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3); }

        .main-content { margin-left: var(--sidebar-width); padding: 50px 60px; }
        
        /* SCANNER UI */
        .scanner-wrapper {
            background: white;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        #reader { 
            width: 100% !important; 
            border: none !important; 
            border-radius: 20px;
            overflow: hidden;
        }

        /* RESULT CARD */
        .result-card {
            background: white;
            border-radius: 35px;
            padding: 45px;
            display: none;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-title {
            font-size: 0.7rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            display: block;
        }

        .info-pill {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid #f1f5f9;
        }

        .book-detail-box {
            display: flex;
            align-items: center;
            padding: 20px;
            background: #fcfcfd;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
        }

        .btn-action {
            background: var(--brand-dark);
            color: white;
            border: none;
            border-radius: 18px;
            padding: 22px;
            font-weight: 800;
            width: 100%;
            transition: 0.3s;
            text-transform: uppercase;
        }
        .btn-action:hover {
            background: var(--brand-primary);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
        }

        #placeholder-ui {
            min-height: 500px;
            border: 3px dashed #e2e8f0;
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(248, 250, 252, 0.5);
        }

        .avatar-frame {
            width: 80px; height: 80px;
            border-radius: 20px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <a href="#" class="sidebar-brand">
        <i class="fa-solid fa-cube"></i> TREASURE<span>CORE</span>
    </a>
    <nav>
        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="{{ route('admin.user.index') }}"><i class="fa-solid fa-users"></i> Members</a>
        <a href="{{ route('admin.buku.index') }}"><i class="fa-solid fa-book"></i> Archive</a>
        <a href="{{ route('admin.peminjaman.index') }}" class="active"><i class="fa-solid fa-qrcode"></i> Terminal Scan</a>
    </nav>
</aside>

<main class="main-content">
    <header class="mb-5">
        <span class="section-title">Operation Mode</span>
        <h1 class="fw-800" style="letter-spacing: -1.5px; font-size: 2.5rem;">Loan Processing</h1>
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
                    <p class="fw-800 text-muted mb-0">AWAITING SIGNAL DATA</p>
                </div>
            </div>

            <div id="result-card" class="result-card">
                <span class="section-title">Verification Successful</span>
                
                <div class="d-flex align-items-center mb-4">
                    <img src="" id="res-foto" class="avatar-frame me-4 bg-light" onerror="this.src='https://ui-avatars.com/api/?name=User&background=4361ee&color=fff'">
                    <div>
                        <div class="fw-800 fs-4" id="res-nama">Member Fullname</div>
                        <div class="text-muted fw-600" id="res-email">member@library.com</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-pill">
                            <span class="section-title" style="font-size: 0.6rem; margin-bottom: 5px;">Member Identity</span>
                            <div class="fw-800 text-primary fs-5" id="res-id">#ID-00000</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-pill">
                            <span class="section-title" style="font-size: 0.6rem; margin-bottom: 5px;">Deadline Target</span>
                            <div class="fw-800 text-danger fs-5" id="res-tgl-kembali">--/--/--</div>
                        </div>
                    </div>
                </div>

                <span class="section-title">Asset Recognition</span>
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
                    
                    <button type="submit" class="btn-action shadow-lg" id="submitBtn">COMMIT TRANSACTION</button>
                    <button type="button" onclick="window.location.reload()" class="btn btn-link w-100 mt-2 text-muted text-decoration-none fw-bold small opacity-50">ABORT PROCESS</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText) {
        // Stop scanner setelah dapat data
        html5QrcodeScanner.clear();
        
        // Parsing data dari QR (Format: USER_ID:1|BUKU_ID:5|KEMBALI:2024-12-30)
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

        // Ambil data detail via AJAX
        fetch(`/admin/get-peminjam/${rawData.USER_ID}/${rawData.BUKU_ID}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('placeholder-ui').style.display = 'none';
                    document.getElementById('result-card').style.display = 'block';
                    
                    // Render UI Result
                    document.getElementById('res-nama').innerText = data.user.nama;
                    document.getElementById('res-email').innerText = data.user.email;
                    document.getElementById('res-foto').src = data.user.foto;
                    document.getElementById('res-id').innerText = "#ID-" + data.user.id_asli;
                    document.getElementById('res-tgl-kembali').innerText = rawData.KEMBALI || 'N/A';
                    document.getElementById('res-buku-judul').innerText = data.buku.judul;
                    document.getElementById('res-buku-kode').innerText = "CODE: " + data.buku.kode;
                    document.getElementById('res-buku-cover').src = data.buku.cover_url;
                    
                    // Isi Hidden Inputs untuk disubmit ke Controller
                    document.getElementById('user_id_input').value = data.user.id_asli;
                    document.getElementById('buku_id_input').value = data.buku.id;
                    document.getElementById('tgl_kembali_input').value = rawData.KEMBALI || '';
                } else {
                    alert(data.message);
                    window.location.reload();
                }
            })
            .catch(err => {
                console.error(err);
                alert("Gagal mengambil data transaksi.");
                window.location.reload();
            });
    }

    // Efek loading pada tombol saat diklik
    document.getElementById('transactionForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> PROCESSING...';
        btn.disabled = true;
        btn.style.opacity = '0.7';
    });

    // Inisialisasi Scanner
    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 25, 
        qrbox: {width: 280, height: 280}
    });
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>