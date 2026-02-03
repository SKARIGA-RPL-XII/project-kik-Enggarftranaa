<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasure Library | Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #ffffff;
            --dark-navy: #121826;
            --accent-blue: #3b82f6;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark-navy);
            overflow-x: hidden;
        }

        /* --- NAVBAR --- */
        .navbar {
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #f1f5f9;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 1.6rem;
        }
        .nav-link-history {
            text-decoration: none;
            color: var(--dark-navy);
            font-weight: 700;
            font-size: 0.9rem;
        }
        .user-pill {
            background: #f1f5f9;
            padding: 5px 15px 5px 5px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }
        .avatar {
            width: 32px; height: 32px;
            background: var(--dark-navy);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: bold;
        }

        /* --- HERO SECTION --- */
        .hero-section {
            background: #1e2535;
            border-radius: 40px;
            padding: 70px 80px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 50px;
        }
        .hero-badge {
            background: var(--accent-blue);
            color: white;
            padding: 6px 16px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 25px;
            display: inline-block;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 25px;
            max-width: 650px;
        }
        .btn-explore {
            background: white;
            color: var(--dark-navy);
            border-radius: 12px;
            padding: 14px 30px;
            font-weight: 800;
            border: none;
            margin-right: 15px;
        }
        .btn-loans {
            background: transparent;
            color: white;
            border: 1.5px solid #475569;
            border-radius: 12px;
            padding: 14px 30px;
            font-weight: 800;
        }
        .hero-image {
            position: absolute;
            right: 60px; bottom: -20px;
            width: 350px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
        }

        /* --- CATEGORY PILLS --- */
        .category-container {
            margin-bottom: 40px;
            display: flex;
            gap: 12px;
            overflow-x: auto;
        }
        .cat-pill {
            padding: 10px 25px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            white-space: nowrap;
        }
        .cat-pill.active {
            background: var(--dark-navy);
            color: white;
            border-color: var(--dark-navy);
        }

        /* --- BOOK CARDS (PERBAIKAN JARAK TEKS) --- */
        .book-item {
            margin-bottom: 40px;
            transition: 0.4s ease;
            cursor: pointer;
        }
        .book-cover-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #f8fafc;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 18px; /* Ditingkatkan sedikit agar tidak menumpuk */
            border: 1px solid #f1f5f9;
        }
        .book-cover-wrapper img { 
            max-width: 85%; 
            max-height: 85%; 
            object-fit: contain; /* Gambar utuh, tidak ter-crop */
            filter: drop-shadow(0 8px 15px rgba(0,0,0,0.1));
        }
        .category-tag {
            position: absolute;
            top: 15px; left: 15px;
            background: white;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.65rem; font-weight: 800;
            color: var(--accent-blue);
            z-index: 10;
        }
        .book-info {
            padding: 0 5px;
        }
        .book-title {
            font-weight: 800;
            font-size: 1.05rem;
            margin-bottom: 2px;
            display: block;
        }
        .book-author {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* --- MODAL --- */
        .modal-content { border-radius: 30px; border: none; }
        .btn-pinjam {
            background: var(--dark-navy);
            color: white;
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            text-decoration: none;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">Treasure <span class="text-primary">Library</span></a>
        <div class="d-flex align-items-center gap-4">
            <a href="#" class="nav-link-history">My History 📜</a>
            <a href="#" class="user-pill">
                <div class="avatar">a</div>
                <span class="fw-bold small">asa <i class="fas fa-chevron-down ms-1" style="font-size: 0.65rem; opacity: 0.5;"></i></span>
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="hero-section">
        <div class="hero-badge">Premium Access</div>
        <h1 class="hero-title">Discover Your Next Masterpiece.</h1>
        <p class="text-white-50 mb-4" style="max-width: 500px;">Eksplorasi koleksi literatur terbaik dari seluruh dunia secara digital di Treasure International School.</p>
        <div class="d-flex mb-4">
            <button class="btn-explore">Explore Now</button>
            <button class="btn-loans">View My Loans</button>
        </div>
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/online-library-illustration-download-in-svg-png-gif-file-formats--internet-education-learning-study-pack-school-delivery-illustrations-4845517.png" class="hero-image">
    </div>

    <div class="category-container">
        <a href="#" class="cat-pill active">All Collections</a>
        <a href="#" class="cat-pill">Literature</a>
        <a href="#" class="cat-pill">Science</a>
        <a href="#" class="cat-pill">History</a>
        <a href="#" class="cat-pill">Philosophy</a>
        <a href="#" class="cat-pill">Technology</a>
    </div>

    <div class="row">
        @foreach($buku as $b)
        <div class="col-6 col-md-3">
            <div class="book-item" data-bs-toggle="modal" data-bs-target="#modalBuku{{ $b->id }}">
                <div class="book-cover-wrapper">
                    <div class="category-tag">{{ $b->kategori->nama ?? 'Book' }}</div>
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?q=80&w=1000&auto=format&fit=crop' }}">
                </div>
                <div class="book-info">
                    <span class="book-title text-truncate">{{ $b->judul }}</span>
                    <span class="book-author">{{ $b->penulis }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@foreach($buku as $b)
<div class="modal fade" id="modalBuku{{ $b->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content p-4">
            <div class="text-end mb-2">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="text-center">
                <img src="{{ $b->cover ? asset('storage/' . $b->cover) : '' }}" class="mb-4 shadow" style="width: 150px; border-radius: 12px;">
                <h4 class="fw-bold mb-1" style="font-family: 'Playfair Display';">{{ $b->judul }}</h4>
                <p class="text-muted small">Oleh {{ $b->penulis }}</p>
                
                <div class="bg-light p-3 rounded-4 my-4 d-flex justify-content-around text-center">
                    <div><small class="text-muted d-block">Stok</small><b>{{ $b->stok }}</b></div>
                    <div><small class="text-muted d-block">Tahun</small><b>{{ $b->tahun_terbit }}</b></div>
                </div>

                <p class="text-muted small text-start mb-4" style="line-height: 1.6;">{{ $b->deskripsi }}</p>

                <a href="{{ route('user.generate.qr', $b->id) }}" class="btn-pinjam">
    Pinjam Sekarang
</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>