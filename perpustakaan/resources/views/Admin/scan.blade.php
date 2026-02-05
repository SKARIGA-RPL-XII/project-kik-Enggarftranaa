<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner QR | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --accent: #4cc9f0;
            --dark-sidebar: #1e1e2d;
            --bg-light: #f4f7fe;
        }

        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; }

        /* SIDEBAR */
        .sidebar { height: 100vh; background: var(--dark-sidebar); color: #fff; position: fixed; width: 16.6%; z-index: 100; }
        .sidebar-brand { padding: 30px 25px; font-weight: 700; font-size: 1.25rem; color: white; text-decoration: none; display: block; }
        .sidebar-brand span { color: var(--accent); }
        .sidebar a { color: #a2a3b7; display: flex; align-items: center; padding: 14px 18px; text-decoration: none; transition: 0.3s; border-radius: 12px; margin: 0 20px 8px; font-size: 0.9rem; }
        .sidebar a.active { background: var(--primary); color: white; }

        /* CONTENT */
        .main-content { margin-left: 16.6%; padding: 40px; }
        .scanner-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: none; }
        #reader { width: 100%; border-radius: 20px; overflow: hidden; border: none !important; }

        /* INFO CARD */
        .result-card { background: white; border-radius: 24px; padding: 35px; display: none; box-shadow: 0 15px 35px rgba(0,0,0,0.08); animation: slideUp 0.5s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .user-profile-img { width: 80px; height: 80px; object-fit: cover; border-radius: 20px; border: 3px solid #f0f4ff; }
        .data-box { background: #f8fafc; border-radius: 18px; padding: 15px; border-left: 4px solid var(--primary); height: 100%; }
        .info-label { font-size: 0.7rem; font-weight: 800; color: #adb5bd; text-transform: uppercase; margin-bottom: 3px; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar d-none d-md-block">
            <a href="#" class="sidebar-brand">Treasure<span>Library</span></a>
            <div class="mt-4">
                <a href="/admin/dashboard">🏠 Dashboard</a>
                <a href="/admin/user">👥 Data Anggota</a>
                <a href="/admin/buku">📚 Koleksi Buku</a>
                <a href="#" class="active">📸 Scan Peminjaman</a>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <h2 class="fw-800 mb-4">Scanner Peminjaman</h2>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="scanner-card text-center">
                        <div id="reader"></div>
                        <div id="status-text" class="mt-3 text-muted small">Kamera Siap</div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div id="placeholder-card" class="scanner-card d-flex align-items-center justify-content-center text-center" style="min-height: 400px; border: 2px dashed #cbd5e0; background: transparent;">
                        <div>
                            <div style="font-size: 4rem; opacity: 0.3;">📸</div>
                            <h5 class="text-muted mt-3">Silakan Scan QR Code Transaksi</h5>
                        </div>
                    </div>

                    <div id="result-card" class="result-card">
                        <div class="d-flex align-items-center mb-4">
                            <img src="" id="res-foto" class="user-profile-img me-3">
                            <div>
                                <h4 class="fw-bold mb-1" id="res-nama">Nama Peminjam</h4>
                                <span class="badge bg-primary rounded-pill" id="res-email">email@library.com</span>
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="data-box">
                                    <div class="info-label">ID Peminjam</div>
                                    <div class="fw-bold text-dark" id="res-id">#USER-0</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-box" style="border-left-color: #ff9f43;">
                                    <div class="info-label">Status Verifikasi</div>
                                    <div class="fw-bold text-success">Anggota Aktif</div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.proses.pinjam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id_input">
                            <input type="hidden" name="payload" id="payload_input">
                            
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-lg">
                                KONFIRMASI PEMINJAMAN
                            </button>
                            <button type="button" onclick="location.reload()" class="btn btn-link w-100 mt-2 text-muted text-decoration-none small">Batal & Scan Ulang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner
        html5QrcodeScanner.clear();
        document.getElementById('status-text').innerText = "Memproses Payload...";

        // Gunakan encodeURIComponent karena string mengandung karakter khusus seperti '|' dan ':'
        fetch(`/admin/get-peminjam/${encodeURIComponent(decodedText)}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('placeholder-card').style.display = 'none';
                    document.getElementById('result-card').style.display = 'block';
                    
                    // Isi Data ke Tampilan
                    document.getElementById('res-nama').innerText = data.user.nama;
                    document.getElementById('res-email').innerText = data.user.email;
                    document.getElementById('res-foto').src = data.user.foto;
                    document.getElementById('res-id').innerText = "#ID-" + data.user.id_asli;
                    
                    // Isi Hidden Input untuk Form Submit
                    document.getElementById('user_id_input').value = data.user.id_asli;
                    document.getElementById('payload_input').value = decodedText;
                } else {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan koneksi ke server.");
                location.reload();
            });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 20, // Lebih cepat lebih baik
        qrbox: {width: 250, height: 250},
        aspectRatio: 1.0 
    });
    html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>