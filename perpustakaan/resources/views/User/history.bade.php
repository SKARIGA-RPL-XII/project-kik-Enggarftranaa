<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My History | Treasure Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; color: #121826; }
        .navbar-brand { font-family: 'Playfair Display', serif; font-weight: 900; font-size: 1.6rem; color: #121826; text-decoration: none; }
        .history-card { background: white; border-radius: 25px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: 0.3s; }
        .badge-status { border-radius: 10px; padding: 6px 15px; font-weight: 700; font-size: 0.75rem; }
        .book-thumb { width: 60px; height: 85px; object-fit: cover; border-radius: 10px; }
    </style>
</head>
<body>

<nav class="navbar bg-white border-bottom py-3 mb-5">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">Treasure <span class="text-primary">Library</span></a>
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

<div class="container">
    <div class="mb-4">
        <h2 class="fw-800" style="letter-spacing: -1px;">Riwayat Peminjaman 📜</h2>
        <p class="text-muted">Pantau buku yang sedang kamu baca dan yang sudah dikembalikan.</p>
    </div>

    @if($peminjamans->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-book-reader fa-3x text-light mb-3"></i>
        <h5 class="fw-bold">Belum ada riwayat</h5>
        <p class="text-muted">Kamu belum pernah meminjam buku apa pun.</p>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white rounded-4 overflow-hidden shadow-sm">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3">Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $p)
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $p->buku->cover ? asset('storage/' . $p->buku->cover) : 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?q=80&w=100' }}" class="book-thumb">
                            <div>
                                <div class="fw-bold mb-0">{{ $p->buku->judul }}</div>
                                <small class="text-muted">{{ $p->buku->penulis }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="fw-600">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</span></td>
                    <td><span class="fw-600 text-danger">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d M Y') }}</span></td>
                    <td>
                        @if($p->status == 'AKTIF')
                            <span class="badge bg-primary-subtle text-primary badge-status">SEDANG DIBACA</span>
                        @else
                            <span class="badge bg-success-subtle text-success badge-status">DIKEMBALIKAN</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

</body>
</html>