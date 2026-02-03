<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Catalog | Treasure International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-dark: #0f172a; /* Midnight Blue */
            --accent-blue: #3b82f6;  /* Royal Blue */
            --soft-blue: #f1f5f9;
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body { 
            background-color: #f8fafc; 
            font-family: 'Inter', sans-serif;
            color: var(--primary-dark);
        }

        /* HEADER: Menyesuaikan dengan gaya Login */
        .modern-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: white;
            padding: 120px 0 160px 0;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
        }

        .modern-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .btn-back {
            position: absolute;
            top: 40px;
            left: 40px;
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.2);
            transition: 0.3s ease;
        }

        .btn-back:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateX(-5px);
        }

        /* SEARCH SECTION */
        .search-container {
            margin-top: -100px;
            z-index: 10;
            position: relative;
        }

        .search-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.15);
        }

        .form-control, .form-select {
            height: 55px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f1f5f9;
            font-weight: 500;
        }

        .form-control:focus {
            background: white;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-search {
            background: var(--primary-dark);
            color: white;
            height: 55px;
            border-radius: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-search:hover {
            background: var(--accent-blue);
            transform: translateY(-2px);
            color: white;
        }

        /* BOOK CARDS */
        .book-card {
            border: none;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .book-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1);
        }

        .cover-container {
            position: relative;
            height: 380px;
            overflow: hidden;
        }

        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.05);
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.7rem;
            letter-spacing: 1px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }

        .book-info { padding: 25px; }

        .book-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--primary-dark);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        /* MODAL MODERN */
        .modal-modern .modal-content {
            border-radius: 30px;
            border: none;
            overflow: hidden;
        }

        .info-pill {
            background: var(--soft-blue);
            border-radius: 16px;
            padding: 18px;
            border-left: 5px solid var(--accent-blue);
        }

        .btn-borrow {
            background: var(--primary-dark);
            color: white;
            border-radius: 15px;
            padding: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .btn-borrow:hover {
            background: var(--accent-blue);
            color: white;
        }
    </style>
</head>
<body>

<header class="modern-header text-center">
    <a href="/user/dashboard" class="btn-back">← Dashboard</a>
    <div class="container">
        <h1>Treasure Catalog</h1>
        <p class="opacity-75" style="letter-spacing: 2px; font-weight: 300;">THE LUXURY OF KNOWLEDGE</p>
    </div>
</header>

<div class="container pb-5">
    <div class="row justify-content-center search-container mb-5">
        <div class="col-lg-10">
            <div class="search-card">
                <form action="{{ route('user.buku') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="small fw-bold text-muted mb-2 ms-1">PENCARIAN</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted mb-2 ms-1">KATEGORI</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Koleksi</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-search w-100">CARI KOLEKSI</button>
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
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://images.unsplash.com/photo-1543004407-0f9bd707f461?q=80&w=1000&auto=format&fit=crop' }}" 
                         class="book-cover" alt="{{ $b->judul }}">
                    
                    <span class="status-badge {{ $b->stok > 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                        {{ $b->stok > 0 ? 'Tersedia' : 'Dipinjam' }}
                    </span>
                </div>
                
                <div class="book-info text-center">
                    <h5 class="book-title">{{ $b->judul }}</h5>
                    <p class="text-muted small mb-4">{{ $b->penulis }}</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-dark btn-sm rounded-pill py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#detailModal{{ $b->id }}">
                            DETAIL BUKU
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-modern" id="detailModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-md-5 mb-4 mb-md-0">
                                <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://via.placeholder.com/400x600' }}" 
                                     class="img-fluid rounded-4 shadow-lg">
                            </div>
                            <div class="col-md-7">
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-3">{{ $b->kategori->nama ?? 'Collection' }}</span>
                                <h2 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif;">{{ $b->judul }}</h2>
                                <p class="text-muted mb-4">By <span class="text-dark fw-bold">{{ $b->penulis }}</span></p>
                                
                                <h6 class="fw-bold text-uppercase small text-primary mb-2">Sinopsis</h6>
                                <p class="text-secondary small mb-4" style="line-height: 1.8;">
                                    {{ $b->deskripsi ?? 'No description available for this prestigious collection.' }}
                                </p>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="info-pill text-center">
                                            <small class="text-muted d-block mb-1">AVAILABILITY</small>
                                            <span class="fw-bold h5 mb-0 text-primary">{{ $b->stok }} Units</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-pill text-center">
                                            <small class="text-muted d-block mb-1">LOCATION</small>
                                            <span class="fw-bold h5 mb-0 text-primary">ZONE {{ chr(65 + ($b->id % 5)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid">
                                    @if($b->stok > 0)
                                        <a href="{{ route('user.generate.qr', $b->id) }}" class="btn btn-borrow shadow-lg">
                                            REQUEST LOAN ACCESS
                                        </a>
                                    @else
                                        <button class="btn btn-secondary py-3 fw-bold shadow-sm" disabled>OUT OF STOCK</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="text-muted fw-bold">No collections found.</h3>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>