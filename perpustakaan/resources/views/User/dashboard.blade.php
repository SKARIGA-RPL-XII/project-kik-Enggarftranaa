<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treasure Library | Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --accent: #4cc9f0;
            --dark: #1e1e2d;
            --text-muted: #7e8299;
            --bg-body: #f4f7fe;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
        }

        /* Navbar Modern */
        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.2rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
            font-size: 1.5rem;
        }

        /* Greeting Section */
        .welcome-section {
            padding: 40px 0;
        }

        .welcome-title {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 8px;
        }

        /* Modern Card Design */
        .custom-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 40px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .custom-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .custom-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.15);
        }

        .custom-card:hover::before {
            opacity: 1;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin-bottom: 20px;
            transition: all 0.4s ease;
        }

        .custom-card:hover .icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(-10deg);
        }

        .card-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 8px;
            transition: color 0.4s ease;
        }

        .card-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            transition: color 0.4s ease;
        }

        .custom-card:hover .card-title,
        .custom-card:hover .card-desc {
            color: white;
        }

        /* Logout Card Specific */
        .card-logout:hover::before {
            background: linear-gradient(135deg, #f72585, #ff4d6d);
        }
        
        .logout-wrapper {
            background: rgba(247, 37, 133, 0.1);
        }

        /* Modal Modern */
        .modal-modern .modal-content {
            border: none;
            border-radius: 24px;
            padding: 20px;
        }

        .btn-round {
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-cancel {
            background: #f1f3f9;
            color: #5e6278;
            border: none;
        }

        .btn-confirm {
            background: #f72585;
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(247, 37, 133, 0.3);
        }

        .btn-confirm:hover {
            background: #d61f71;
            transform: scale(1.05);
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <span class="navbar-brand">Treasure<span style="color: var(--accent);"> Library</span></span>
        <div class="d-flex align-items-center bg-light px-3 py-2 rounded-pill shadow-sm">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 0.8rem; font-weight: bold;">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <span class="small fw-bold text-dark">{{ Auth::user()->name ?? 'Member' }}</span>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="welcome-section text-center text-md-start">
        <h1 class="welcome-title">Halo, Selamat Datang 👋</h1>
        <p class="text-muted">Jelajahi harta karun pengetahuan di Treasure International School.</p>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <a href="/user/buku" class="text-decoration-none h-100">
                <div class="card custom-card shadow-sm">
                    <div class="icon-wrapper">📖</div>
                    <h4 class="card-title">Katalog Buku</h4>
                    <p class="card-desc">Cari koleksi literatur terbaru</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="/user/riwayat" class="text-decoration-none h-100">
                <div class="card custom-card shadow-sm">
                    <div class="icon-wrapper">🕒</div>
                    <h4 class="card-title">Riwayat Pinjam</h4>
                    <p class="card-desc">Pantau status akses Anda</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <div class="card custom-card card-logout shadow-sm" 
                 style="cursor: pointer;" 
                 data-bs-toggle="modal" 
                 data-bs-target="#logoutModal">
                <div class="icon-wrapper logout-wrapper">🚪</div>
                <h4 class="card-title">Keluar Sesi</h4>
                <p class="card-desc">Akhiri akses pangkalan data</p>
            </div>
        </div>
    </div>

    <div class="footer text-center mt-5 pt-5">
        <p class="small text-muted mb-0">&copy; 2026 Treasure Library Management System</p>
        <p class="small text-primary fw-bold">Treasure International School</p>
    </div>
</div>

<div class="modal fade modal-modern" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-body text-center py-5">
                <div class="mb-4">
                    <span style="font-size: 4rem;">🗝️</span>
                </div>
                <h3 class="fw-bold mb-3">Konfirmasi Keluar</h3>
                <p class="text-muted mb-5">Apakah Anda yakin ingin mengunci kembali akses ke pangkalan data Treasure Library?</p>
                
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-round btn-cancel px-5" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-round btn-confirm px-5" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Ya, Selesaikan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>     