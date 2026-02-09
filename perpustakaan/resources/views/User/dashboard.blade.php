<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasure Library | Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
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

        /* --- USER PILL --- */
        .user-pill {
            background: #f1f5f9;
            padding: 5px 15px 5px 5px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        .user-pill:hover { background: #e2e8f0; }
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
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 25px;
            max-width: 600px;
        }
        .hero-image {
            position: absolute;
            right: 40px; bottom: -20px;
            width: 320px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
        }

        /* --- SEARCH BAR --- */
        .search-container {
            position: relative;
            max-width: 500px;
            margin-bottom: 40px;
        }
        .search-container i {
            position: absolute;
            left: 20px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        .search-input {
            padding: 15px 20px 15px 55px;
            border-radius: 20px;
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
        }
        .search-input:focus {
            background: white;
            border-color: var(--accent-blue);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* --- CATEGORIES --- */
        .category-container {
            margin-bottom: 30px;
            display: flex; gap: 10px;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        .cat-pill {
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            white-space: nowrap;
            transition: 0.3s;
            cursor: pointer;
        }
        .cat-pill:hover { background: #f1f5f9; }
        .cat-pill.active { background: var(--dark-navy); color: white; border-color: var(--dark-navy); }

        /* --- BOOK ITEM --- */
        .book-item { margin-bottom: 35px; transition: 0.4s ease; cursor: pointer; }
        .book-item:hover { transform: translateY(-10px); }
        .book-cover-wrapper {
            position: relative;
            border-radius: 24px;
            background: #f8fafc;
            height: 320px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            margin-bottom: 15px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }
        .book-cover-wrapper img { max-width: 80%; max-height: 85%; object-fit: contain; border-radius: 8px; }
        .book-title { display: block; font-weight: 800; font-size: 1rem; color: var(--dark-navy); margin-top: 5px; }
        .book-author { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; }

        /* --- EMPTY STATE (Baru) --- */
        #emptyState {
            display: none;
            text-align: center;
            width: 100%;
            padding: 50px 0;
        }
        #emptyState i { font-size: 3rem; color: #e2e8f0; margin-bottom: 15px; }
        #emptyState h5 { font-weight: 700; color: var(--dark-navy); }

        /* --- MODAL CUSTOM --- */
        .book-description {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.6;
            text-align: justify;
            max-height: 150px;
            overflow-y: auto;
            padding-right: 10px;
            margin: 20px 0;
        }
        .book-description::-webkit-scrollbar { width: 4px; }
        .book-description::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        .input-tanggal {
            border: 2px solid #f1f5f9;
            border-radius: 15px;
            padding: 12px;
            font-weight: 600;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">Treasure <span class="text-primary">Library</span></a>
        
        <div class="d-flex align-items-center gap-4">
            <a href="#" class="text-decoration-none text-dark fw-bold small">My History 📜</a>
            
            <div class="dropdown">
                <div class="user-pill dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown">
                    <div class="avatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                    <span class="fw-bold small">{{ Auth::user()->name ?? 'User' }}</span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-3">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button class="dropdown-item text-danger w-100 text-start" onclick="confirmLogout()"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

<div class="container mt-4">
    <div class="hero-section">
        <div class="hero-badge" style="background: var(--accent-blue); color: white; padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; display: inline-block; margin-bottom: 25px;">Premium Access</div>
        <h1 class="hero-title">Discover Your Next Masterpiece.</h1>
        <p class="text-white-50 mb-4" style="max-width: 500px;">Eksplorasi koleksi literatur terbaik dunia secara digital dalam satu genggaman.</p>
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/online-library-illustration-download-in-svg-png-gif-file-formats--internet-education-learning-study-pack-school-delivery-illustrations-4845517.png" class="hero-image d-none d-lg-block">
    </div>

    <div class="row align-items-center mb-2">
        <div class="col-md-6">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari judul buku atau penulis...">
            </div>
        </div>
        <div class="col-md-6 text-md-end mb-4 mb-md-0">
            <div class="category-container justify-content-md-end">
                <div class="cat-pill active" data-filter="all">All Collections</div>
                @foreach($categories ?? [] as $cat)
                    <div class="cat-pill" data-filter="{{ strtolower($cat->nama) }}">{{ $cat->nama }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row" id="bookGrid">
        @isset($buku)
            @foreach($buku as $b)
            <div class="col-6 col-md-3 book-card" 
                 data-title="{{ strtolower($b->judul) }}" 
                 data-author="{{ strtolower($b->penulis) }}"
                 data-category="{{ strtolower($b->kategori->nama ?? 'umum') }}">
                <div class="book-item" data-bs-toggle="modal" data-bs-target="#modalBuku{{ $b->id }}">
                    <div class="book-cover-wrapper">
                        <span class="badge bg-white text-primary position-absolute top-0 start-0 m-3 shadow-sm">{{ $b->kategori->nama ?? 'Umum' }}</span>
                        <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?q=80&w=1000' }}">
                    </div>
                    <div class="book-info text-center">
                        <span class="book-title text-truncate">{{ $b->judul }}</span>
                        <span class="book-author">{{ $b->penulis }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        @endisset

        <div id="emptyState" class="animate__animated animate__fadeIn">
            <i class="fas fa-book-open"></i>
            <h5>Buku tidak tersedia</h5>
            <p class="text-muted">Maaf, kami tidak dapat menemukan koleksi yang sesuai dengan pencarian Anda.</p>
        </div>
    </div>
</div>

@isset($buku)
    @foreach($buku as $b)
    <div class="modal fade" id="modalBuku{{ $b->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
            <div class="modal-content p-4 border-0 shadow-lg" style="border-radius: 35px;">
                <div class="text-end mb-1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetModal({{ $b->id }})"></button>
                </div>
                <div class="text-center">
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?q=80&w=1000' }}" 
                         class="mb-4 shadow-lg" style="width: 130px; border-radius: 12px; height: 190px; object-fit: cover;">
                    
                    <h4 class="fw-800 mb-1">{{ $b->judul }}</h4>
                    <p class="text-muted small">Karya <span class="text-dark fw-bold">{{ $b->penulis }}</span></p>

                    <div class="book-description">
                        {{ $b->deskripsi ?? 'Belum ada sinopsis untuk buku ini. Silakan hubungi pustakawan untuk informasi lebih lanjut mengenai konten buku.' }}
                    </div>
                    
                    <div class="bg-light p-3 rounded-4 mb-4 d-flex justify-content-around text-center">
                        <div><small class="text-muted d-block small">Tersedia</small><b>{{ $b->stok }} eks</b></div>
                        <div><small class="text-muted d-block small">Tahun</small><b>{{ $b->tahun_terbit }}</b></div>
                        <div><small class="text-muted d-block small">Kategori</small><b>{{ $b->kategori->nama ?? 'Umum' }}</b></div>
                    </div>

                    <div id="initialStep{{ $b->id }}">
                        <button type="button" class="btn btn-dark w-100 py-3 rounded-4 fw-bold shadow-sm" 
                                onclick="showDateStep({{ $b->id }})" {{ $b->stok <= 0 ? 'disabled' : '' }}>
                            {{ $b->stok > 0 ? 'Pinjam Sekarang' : 'Stok Habis' }} <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>

                    <form action="{{ route('user.generate.qr', $b->id) }}" method="GET" 
                          id="dateStep{{ $b->id }}" style="display: none;" class="text-start animate__animated animate__fadeInUp">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">KAPAN BUKU DIKEMBALIKAN?</label>
                            <input type="date" name="tgl_kembali" class="form-control input-tanggal" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-sm">
                             Konfirmasi & Generate QR <i class="fas fa-qrcode ms-2"></i>
                        </button>
                        <button type="button" class="btn btn-link w-100 btn-sm mt-2 text-muted text-decoration-none" 
                                onclick="resetModal({{ $b->id }})">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endisset

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const searchInput = document.getElementById('searchInput');
    const catPills = document.querySelectorAll('.cat-pill');
    const bookCards = document.querySelectorAll('.book-card');
    const emptyState = document.getElementById('emptyState');

    let currentCategory = 'all';

    function filterBooks() {
        const keyword = searchInput.value.toLowerCase();
        let visibleCount = 0;

        bookCards.forEach(card => {
            const title = card.getAttribute('data-title');
            const author = card.getAttribute('data-author');
            const category = card.getAttribute('data-category');

            const matchesSearch = title.includes(keyword) || author.includes(keyword);
            const matchesCategory = currentCategory === 'all' || category === currentCategory;

            if (matchesSearch && matchesCategory) {
                card.style.display = "block";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        // Cek jika tidak ada buku yang muncul
        if (visibleCount === 0) {
            emptyState.style.display = "block";
        } else {
            emptyState.style.display = "none";
        }
    }

    searchInput.addEventListener('input', filterBooks);

    catPills.forEach(pill => {
        pill.addEventListener('click', function() {
            catPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.getAttribute('data-filter');
            filterBooks();
        });
    });

    function showDateStep(id) {
        document.getElementById('initialStep' + id).style.display = 'none';
        document.getElementById('dateStep' + id).style.display = 'block';
    }

    function resetModal(id) {
        document.getElementById('initialStep' + id).style.display = 'block';
        document.getElementById('dateStep' + id).style.display = 'none';
    }

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