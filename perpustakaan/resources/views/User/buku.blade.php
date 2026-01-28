<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku | Bibliotheca Classic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #1e293b;
            --accent: #b8926a; /* Classic Gold */
            --paper: #f4f1ea;
        }

        body { 
            background-color: #f8f9fa; 
            font-family: 'Inter', sans-serif;
            color: var(--bg-dark);
        }

        /* Header Classic */
        .classic-header {
            background: var(--bg-dark);
            color: white;
            padding: 80px 0;
            border-bottom: 5px solid var(--accent);
            margin-bottom: 50px;
            position: relative;
        }

        .header-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 900;
        }

        .btn-back-dashboard {
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--accent);
            text-decoration: none;
            border: 1px solid var(--accent);
            padding: 8px 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-back-dashboard:hover {
            background: var(--accent);
            color: white;
        }

        /* Search & Filter Box */
        .search-box {
            background: white;
            border: 1px solid #ddd;
            border-left: 5px solid var(--accent);
            padding: 25px;
            margin-top: -80px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }

        .form-control, .form-select {
            border-radius: 0;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
        }

        .btn-gold {
            background: var(--accent);
            color: white;
            border: none;
            font-weight: 700;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background: #a07d58;
            color: white;
        }

        /* Book Card Classic */
        .book-card {
            border: none;
            background: white;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .cover-wrapper {
            position: relative;
            height: 380px;
            overflow: hidden;
            border-bottom: 4px solid var(--accent);
            background: #eee;
        }

        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.6s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.08);
            filter: brightness(0.8);
        }

        .book-info {
            padding: 20px;
            text-align: center;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--bg-dark);
            height: 3.2rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .author {
            color: var(--accent);
            font-size: 0.85rem;
            font-style: italic;
            margin-bottom: 15px;
        }

        /* Modal Style */
        .modal-classic .modal-content {
            border-radius: 0;
            border: none;
        }

        .modal-header-classic {
            background: var(--bg-dark);
            color: white;
            border-bottom: 5px solid var(--accent);
            border-radius: 0;
        }

        .detail-img {
            border: 10px solid white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<header class="classic-header text-center">
    <a href="/user/dashboard" class="btn-back-dashboard">
        ← Ke Dashboard
    </a>
    
    <div class="container">
        <h1 class="header-title">Treasure International School</h1>
        <p class="text-uppercase small" style="color: var(--accent); letter-spacing: 4px;">Koleksi Literatur & Pengetahuan Klasik</p>
    </div>
</header>

<div class="container pb-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-11">
            <div class="search-box">
                <form action="{{ route('user.buku') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="small text-uppercase fw-bold mb-1 text-muted">Cari Judul / Penulis</label>
                        <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="small text-uppercase fw-bold mb-1 text-muted">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Sains" {{ request('kategori') == 'Sains' ? 'selected' : '' }}>Sains</option>
                            <option value="Fiksi" {{ request('kategori') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Non Fiksi" {{ request('kategori') == 'Non Fiksi' ? 'selected' : '' }}>Non Fiksi</option>
                            <option value="Album" {{ request('kategori') == 'Album' ? 'selected' : '' }}>Album</option>
                            <option value="Sejarah" {{ request('kategori') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-gold w-100 py-2 rounded-0 text-uppercase fw-bold">FILTER ARSIP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($buku as $b)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card shadow-sm">
                <div class="cover-wrapper">
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://via.placeholder.com/400x600?text=No+Cover' }}" 
                         class="book-cover" alt="{{ $b->judul }}">
                    
                    <div class="position-absolute top-0 start-0 p-2">
                        <span class="badge {{ $b->stok > 0 ? 'bg-success' : 'bg-danger' }} rounded-0">
                            {{ $b->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                </div>
                
                <div class="book-info">
                    <h5 class="book-title">{{ $b->judul }}</h5>
                    <p class="author">{{ $b->penulis }}</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-dark btn-sm rounded-0 text-uppercase fw-bold" data-bs-toggle="modal" data-bs-target="#detailModal{{ $b->id }}">
                            PELAJARI DETAIL
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-classic" id="detailModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header modal-header-classic">
                        <h5 class="modal-title font-playfair">Deskripsi Literatur</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-5">
                        <div class="row">
                            <div class="col-md-5 mb-4 mb-md-0 text-center">
                                <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://via.placeholder.com/400x600?text=No+Cover' }}" 
                                     class="detail-img">
                            </div>
                            <div class="col-md-7">
                                <span class="badge bg-light text-dark border mb-2">{{ $b->kategori ?? 'Umum' }}</span>
                                <h2 class="fw-bold mb-1" style="font-family: 'Playfair Display'; color: var(--bg-dark);">{{ $b->judul }}</h2>
                                <p class="text-muted fst-italic mb-4 small">Ditulis oleh {{ $b->penulis }}</p>
                                
                                <h6 class="text-uppercase small fw-bold" style="color: var(--accent); letter-spacing: 1px;">Sinopsis</h6>
                                <p class="text-secondary small mb-4" style="line-height: 1.8; text-align: justify;">
                                    {{ $b->deskripsi ?? 'Arsip deskripsi untuk buku ini belum tersedia di pangkalan data.' }}
                                </p>
                                
                                <div class="row mb-4 bg-light p-3 border-start border-4" style="border-color: var(--accent) !important;">
                                    <div class="col-6 border-end">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Status Stok</small>
                                        <span class="fw-bold">{{ $b->stok }} Unit</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Lokasi Rak</small>
                                        <span class="fw-bold">A-{{ $b->id + 10 }}</span>
                                    </div>
                                </div>
                                
                                <button class="btn btn-dark w-100 py-2 rounded-0 shadow text-uppercase fw-bold" {{ $b->stok <= 0 ? 'disabled' : '' }}>
                                    AJUKAN PEMINJAMAN
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="text-muted fst-italic">Koleksi tidak ditemukan dalam arsip.</h3>
            <a href="{{ route('user.buku') }}" class="btn btn-link text-dark">Kembali ke Semua Koleksi</a>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>