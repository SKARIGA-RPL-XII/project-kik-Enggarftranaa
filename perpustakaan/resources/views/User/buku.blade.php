<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Digital | Treasure Library Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --accent: #4cc9f0;
            --dark: #1e1e2d;
            --bg-body: #f4f7fe;
            --glass: rgba(255, 255, 255, 0.9);
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
        }

        /* Hero Header Modern */
        .modern-header {
            background: linear-gradient(135deg, #1e1e2d 0%, #4361ee 100%);
            color: white;
            padding: 100px 0 140px 0;
            position: relative;
            border-radius: 0 0 50px 50px;
        }

        .btn-back {
            position: absolute;
            top: 30px;
            left: 30px;
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: white;
            color: var(--primary);
        }

        /* Modern Search Box */
        .search-container {
            margin-top: -70px;
            z-index: 10;
            position: relative;
        }

        .search-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            border: none;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 12px 18px;
            background: #f8fafc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
            border-color: var(--primary);
        }

        .btn-search {
            background: var(--primary);
            color: white;
            border-radius: 12px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-search:hover {
            background: #3651d4;
            transform: translateY(-2px);
            color: white;
        }

        /* Book Card Modern */
        .book-card {
            border: none;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        }

        .cover-container {
            position: relative;
            height: 350px;
            overflow: hidden;
        }

        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.1);
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .book-info {
            padding: 20px;
        }

        .book-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .author-name {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 15px;
            display: block;
        }

        .btn-detail {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 2px solid #f1f3f9;
            color: var(--primary);
        }

        .btn-detail:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* Modal Details Modern */
        .modal-modern .modal-content {
            border-radius: 30px;
            border: none;
            overflow: hidden;
        }

        .detail-img-modern {
            border-radius: 20px;
            width: 100%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .info-pill {
            background: #f8fafc;
            border-radius: 15px;
            padding: 15px;
            border-left: 4px solid var(--primary);
        }
    </style>
</head>
<body>

<header class="modern-header text-center">
    <a href="/user/dashboard" class="btn-back">
        <span class="me-1">←</span> Dashboard
    </a>
    
    <div class="container">
        <h1 class="fw-bold display-5">Treasure Library</h1>
        <p class="opacity-75">Koleksi Pengetahuan Digital Treasure International School</p>
    </div>
</header>

<div class="container pb-5">
    <div class="row justify-content-center search-container mb-5">
        <div class="col-lg-10">
            <div class="search-card">
                <form action="{{ route('user.buku') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="small fw-bold text-muted mb-2 ms-1">Kata Kunci</label>
                        <input type="text" name="search" class="form-control" placeholder="Judul buku atau penulis..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted mb-2 ms-1">Kategori Koleksi</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Sains" {{ request('kategori') == 'Sains' ? 'selected' : '' }}>Sains</option>
                            <option value="Fiksi" {{ request('kategori') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Non Fiksi" {{ request('kategori') == 'Non Fiksi' ? 'selected' : '' }}>Non Fiksi</option>
                            <option value="Sejarah" {{ request('kategori') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-search w-100 py-3 text-uppercase">Cari Koleksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($buku as $b)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card">
                <div class="cover-container">
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://via.placeholder.com/400x600?text=No+Cover' }}" 
                         class="book-cover" alt="{{ $b->judul }}">
                    
                    <span class="status-badge {{ $b->stok > 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                        {{ $b->stok > 0 ? 'Tersedia' : 'Kosong' }}
                    </span>
                </div>
                
                <div class="book-info">
                    <h5 class="book-title">{{ $b->judul }}</h5>
                    <span class="author-name">{{ $b->penulis }}</span>
                    <div class="d-grid">
                        <button class="btn btn-detail py-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $b->id }}">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-modern" id="detailModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-body p-4 p-md-5">
                        <div class="text-end mb-3">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-4 mb-md-0">
                                <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://via.placeholder.com/400x600?text=No+Cover' }}" 
                                     class="detail-img-modern">
                            </div>
                            <div class="col-md-7">
                                <div class="mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $b->kategori ?? 'Umum' }}</span>
                                </div>
                                <h2 class="fw-bold mb-2">{{ $b->judul }}</h2>
                                <p class="text-muted mb-4">Karya luar biasa oleh <span class="text-dark fw-bold">{{ $b->penulis }}</span></p>
                                
                                <h6 class="fw-bold text-uppercase small text-primary mb-2">Sinopsis</h6>
                                <p class="text-secondary small mb-4" style="line-height: 1.7;">
                                    {{ $b->deskripsi ?? 'Sinopsis untuk buku ini belum tersedia. Silakan hubungi pustakawan untuk informasi lebih lanjut mengenai konten literatur ini.' }}
                                </p>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="info-pill">
                                            <small class="text-muted d-block mb-1">Stok Buku</small>
                                            <span class="fw-bold h5 mb-0 text-primary">{{ $b->stok }} Unit</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-pill">
                                            <small class="text-muted d-block mb-1">Lokasi Rak</small>
                                            <span class="fw-bold h5 mb-0 text-primary">Blok {{ chr(65 + ($b->id % 5)) }}-{{ $b->id + 10 }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="d-grid">
    <a href="{{ route('user.generate.qr', $b->id) }}" class="btn btn-primary py-3 fw-bold shadow">
    AJUKAN PEMINJAMAN SEKARANG
</a>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="mb-3" style="font-size: 4rem;">🔍</div>
            <h3 class="text-muted fw-bold">Koleksi Tidak Ditemukan</h3>
            <p class="text-muted">Coba gunakan kata kunci lain di Treasure Library.</p>
            <a href="{{ route('user.buku') }}" class="btn btn-primary px-4 py-2 rounded-pill mt-3">Reset Pencarian</a>
        </div>
        @endforelse
    </div>

    <div class="footer text-center mt-5 pt-5">
        <p class="small text-muted mb-0">&copy; 2026 Treasure Library Management</p>
        <p class="small text-primary fw-bold">Treasure International School</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>