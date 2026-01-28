<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard | Classic Edition</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --midnight: #1a2a6c;
            --gold: #b8926a;
            --soft-red: #8b0000; /* Darker red for classic feel */
            --bg-paper: #fcfaf7;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background-color: var(--midnight) !important;
            border-bottom: 3px solid var(--gold);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Header Title */
        .dashboard-header {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--midnight);
            position: relative;
            display: inline-block;
            margin-bottom: 40px;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--gold);
        }

        /* Classic Card Design */
        .custom-card {
            background: #ffffff;
            border: none;
            border-radius: 0;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-left: 0px solid var(--midnight);
            height: 100%;
        }

        .custom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-left: 8px solid var(--midnight);
        }

        .icon-box {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: block;
            filter: grayscale(100%);
            transition: 0.3s;
        }

        .custom-card:hover .icon-box {
            filter: grayscale(0%);
            transform: scale(1.1);
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--midnight);
        }

        .card-text {
            font-size: 0.85rem;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .card-logout:hover {
            border-left: 8px solid var(--soft-red);
        }

        /* --- CLASSIC MODAL STYLE --- */
        .modal-classic .modal-content {
            border-radius: 0;
            background-color: var(--bg-paper);
            border: 1px solid var(--gold);
            box-shadow: 0 0 0 8px white, 0 0 0 10px var(--gold);
            margin: 15px;
        }

        .modal-classic .modal-body {
            padding: 3.5rem 2rem !important;
            position: relative;
        }

        /* Fleurons / Ornament */
        .modal-classic .modal-body::before {
            content: "❦";
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--gold);
            font-size: 1.8rem;
        }

        .modal-title-classic {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--midnight);
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid var(--gold);
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 25px;
        }

        .modal-text-classic {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.15rem;
            color: #444;
            line-height: 1.6;
        }

        .btn-classic-outline {
            border: 1.5px solid var(--midnight);
            color: var(--midnight);
            background: transparent;
            border-radius: 0;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75rem;
            transition: 0.3s;
        }

        .btn-classic-outline:hover {
            background: #eee;
        }

        .btn-classic-dark {
            background-color: var(--midnight);
            color: white;
            border: 1px solid var(--midnight);
            border-radius: 0;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75rem;
            transition: 0.3s;
        }

        .btn-classic-dark:hover {
            background-color: #0d163f;
            color: var(--gold);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand">BIBLIOTHECA</span>
        <div class="d-flex align-items-center">
            <span class="text-white-50 me-2 small italic">Logged in as:</span>
            <span class="text-white fw-bold">{{ Auth::user()->name ?? 'Tuan User' }}</span>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center text-md-start">
            <h2 class="dashboard-header">Panel Navigasi</h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <a href="/user/buku" class="text-decoration-none h-100">
                <div class="card custom-card p-5 text-center shadow-sm">
                    <span class="icon-box">📚</span>
                    <h4 class="card-title">Katalog Buku</h4>
                    <p class="card-text">Eksplorasi Koleksi</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="/user/riwayat" class="text-decoration-none h-100">
                <div class="card custom-card p-5 text-center shadow-sm">
                    <span class="icon-box">⏳</span>
                    <h4 class="card-title">Arsip Riwayat</h4>
                    <p class="card-text">Catatan Peminjaman</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <div class="card custom-card card-logout p-5 text-center shadow-sm" 
                 style="cursor: pointer;" 
                 data-bs-toggle="modal" 
                 data-bs-target="#logoutModal">
                <span class="icon-box">🚪</span>
                <h4 class="card-title">Keluar Sesi</h4>
                <p class="card-text">Selesaikan Akses</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center text-muted mt-5">
            <hr style="width: 80px; margin: 20px auto; border-top: 3px solid var(--gold);">
            <small style="letter-spacing: 3px; font-weight: 300;">EST. 2024 — ARCHIVE SYSTEM</small>
        </div>
    </div>
</div>

<div class="modal fade modal-classic" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center">
                <h3 class="modal-title-classic">Maklumat Keluar</h3>
                
                <p class="modal-text-classic mb-5 px-3">
                    "Apakah anda yakin ingin mengakhiri sesi akses pada pangkalan data Bibliotheca?"
                </p>
                
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-classic-outline" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-classic-dark shadow-sm" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Selesaikan Sesi
                    </button>
                </div>

                <div class="mt-5">
                    <small style="color: var(--gold); letter-spacing: 2px; font-size: 0.6rem; opacity: 0.8;">
                        SYSTEMA ARCHIVUM — TERMINATE ACCESS
                    </small>
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