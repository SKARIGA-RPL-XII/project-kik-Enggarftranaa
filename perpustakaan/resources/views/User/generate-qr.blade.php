<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7fe; padding-top: 50px; }
        .ticket { background: white; border-radius: 25px; padding: 30px; max-width: 400px; margin: auto; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .qr-box { background: #f8fafc; padding: 20px; border-radius: 15px; margin: 20px 0; border: 2px dashed #4361ee; }
    </style>
</head>
<body>
    <div class="ticket">
        <h5 class="fw-bold">Tiket Peminjaman Digital</h5>
        <p class="text-muted small">Tunjukkan QR ini ke Pustakawan</p>
        
        <hr>
        <div class="text-start mb-3">
            <small class="text-muted d-block">Peminjam:</small>
            <span class="fw-bold">{{ Auth::user()->name }}</span>
        </div>

        <div class="qr-box">
            <img src="{{ $qrUrl }}" alt="QR Code" class="img-fluid">
        </div>

        <div class="text-start mb-4">
            <small class="text-muted d-block">Buku:</small>
            <span class="fw-bold text-primary">{{ $buku->judul }}</span>
        </div>

        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm w-100 mb-2">Simpan PDF</button>
        <a href="/user/buku" class="btn btn-link btn-sm text-decoration-none text-muted">Kembali ke Katalog</a>
    </div>
</body>
</html>