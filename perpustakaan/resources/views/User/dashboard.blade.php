<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasure Library | Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        /* --- NAVIGATION --- */
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
            text-decoration: none;
            color: var(--dark-navy);
        }
        .nav-link-history {
            text-decoration: none;
            color: var(--dark-navy);
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* --- USER DROPDOWN --- */
        .user-pill {
            background: #f1f5f9;
            padding: 5px 15px 5px 5px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none !important;
            color: inherit !important;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .user-pill:hover { background: #e2e8f0; }
        .avatar {
            width: 32px; height: 32px;
            background: var(--dark-navy);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: bold;
            text-transform: uppercase;
        }
        .dropdown-toggle::after { display: none; }
        .dropdown-menu {
            border-radius: 15px;
            padding: 10px;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 15px !important;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dropdown-item {
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 10px 15px;
            transition: all 0.2s;
            color: var(--dark-navy);
        }
        .dropdown-item:hover {
            background: #f8fafc;
            color: var(--accent-blue);
            transform: translateX(5px);
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
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 25px;
            max-width: 650px;
        }
        .hero-image {
            position: absolute;
            right: 60px; bottom: -20px;
            width: 350px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
        }

        /* --- CONTENT STYLES --- */
        .category-container {
            margin-bottom: 40px;
            display: flex; gap: 12px;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        .cat-pill {
            padding: 10px 25px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }
        .cat-pill.active { background: var(--dark-navy); color: white; border-color: var(--dark-navy); }
        .book-item { margin-bottom: 40px; transition: 0.4s ease; cursor: pointer; }
        .book-item:hover { transform: translateY(-10px); }
        .book-cover-wrapper {
            position: relative;
            border-radius: 20px;
            background: #f8fafc;
            height: 350px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 18px;
            border: 1px solid #f1f5f9;
        }
        .book-cover-wrapper img { max-width: 85%; max-height: 85%; object-fit: contain; }

        /* --- SWEETALERT CUSTOM --- */
        .swal2-popup { font-family: 'Plus Jakarta Sans', sans-serif !important; border-radius: 25px !important; }
        .swal2-title { font-family: 'Playfair Display', serif !important; font-weight: 900 !important; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">Treasure <span class="text-primary">Library</span></a>
        
        <div class="d-flex align-items-center gap-4">
            <a href="#" class="nav-link-history">My History 📜</a>
            
            <div class="dropdown">
                <div class="user-pill dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown">
                    <div class="avatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                    <span class="fw-bold small">
                        {{ Auth::user()->name ?? 'User' }} 
                        <i class="fas fa-chevron-down ms-1" style="font-size: 0.65rem; opacity: 0.5;"></i>
                    </span>
                </div>
                
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle me-2 text-muted"></i> Profile Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" style="opacity: 0.05;"></li>
                    <li>
                        <button type="button" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="container mt-4">
    <div class="hero-section">
        <div class="hero-badge" style="background: var(--accent-blue); color: white; padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; display: inline-block; margin-bottom: 25px;">Premium Access</div>
        <h1 class="hero-title">Discover Your Next Masterpiece.</h1>
        <p class="text-white-50 mb-4" style="max-width: 500px;">Eksplorasi koleksi literatur terbaik dari seluruh dunia secara digital.</p>
        <div class="d-flex mb-4">
            <button class="btn btn-light fw-bold px-4 py-3 rounded-3 me-3">Explore Now</button>
            <button class="btn btn-outline-secondary text-white fw-bold px-4 py-3 rounded-3">View Loans</button>
        </div>
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/online-library-illustration-download-in-svg-png-gif-file-formats--internet-education-learning-study-pack-school-delivery-illustrations-4845517.png" class="hero-image">
    </div>

    <div class="category-container">
        <a href="#" class="cat-pill active">All Collections</a>
        <a href="#" class="cat-pill">Literature</a>
        <a href="#" class="cat-pill">Science</a>
        <a href="#" class="cat-pill">History</a>
    </div>

    <div class="row">
        @isset($buku)
            @foreach($buku as $b)
            <div class="col-6 col-md-3">
                <div class="book-item" data-bs-toggle="modal" data-bs-target="#modalBuku{{ $b->id }}">
                    <div class="book-cover-wrapper">
                        <span class="badge bg-white text-primary position-absolute top-0 start-0 m-3 shadow-sm">{{ $b->kategori->nama ?? 'Book' }}</span>
                        <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?q=80&w=1000' }}">
                    </div>
                    <div class="book-info">
                        <span class="book-title text-truncate">{{ $b->judul }}</span>
                        <span class="book-author">{{ $b->penulis }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        @endisset
    </div>
</div>

@isset($buku)
    @foreach($buku as $b)
    <div class="modal fade" id="modalBuku{{ $b->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content p-4">
                <div class="text-end mb-2"><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="text-center">
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : '' }}" class="mb-4 shadow" style="width: 150px; border-radius: 12px;">
                    <h4 class="fw-bold mb-1">{{ $b->judul }}</h4>
                    <p class="text-muted small">Oleh {{ $b->penulis }}</p>
                    <div class="bg-light p-3 rounded-4 my-4 d-flex justify-content-around text-center">
                        <div><small class="text-muted d-block">Stok</small><b>{{ $b->stok }}</b></div>
                        <div><small class="text-muted d-block">Tahun</small><b>{{ $b->tahun_terbit }}</b></div>
                    </div>
                    <p class="text-muted small text-start mb-4">{{ $b->deskripsi }}</p>
                    <a href="{{ route('user.generate.qr', $b->id) }}" class="btn btn-dark w-100 py-3 rounded-4 fw-bold">Pinjam Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endisset

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Ingin keluar?',
            text: "Sampai jumpa lagi di Treasure Library!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#121826',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
</body>
</html>