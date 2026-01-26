<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard | Classic Edition</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        /* Navbar Style */
        .navbar {
            background-color: #1a2a6c !important; /* Midnight Blue */
            border-bottom: 3px solid #b8926a; /* Gold Accent */
            padding: 1rem 2rem;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Header Style */
        .dashboard-header {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #1a2a6c;
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
            background-color: #b8926a;
        }

        /* Card Style - Classic & Minimalist */
        .custom-card {
            background: #ffffff;
            border: none;
            border-radius: 0; /* Boxy look for classic feel */
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-left: 0px solid #1a2a6c;
            overflow: hidden;
        }

        .custom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
            border-left: 8px solid #1a2a6c;
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
            color: #1a2a6c;
        }

        .card-text {
            font-size: 0.9rem;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Logout khusus */
        .card-logout:hover {
            border-left: 8px solid #d9534f;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand">BIBLIOTHECA</span>
        <div class="d-flex align-items-center">
            <span class="text-white-50 me-2">Selamat Datang,</span>
            <span class="text-white fw-bold">Tuan User</span>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="dashboard-header">Panel Navigasi</h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <a href="/user/buku" class="text-decoration-none">
                <div class="card custom-card p-5 text-center shadow-sm">
                    <span class="icon-box">📚</span>
                    <h4 class="card-title">Katalog Buku</h4>
                    <p class="card-text">Eksplorasi Koleksi</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="/user/riwayat" class="text-decoration-none">
                <div class="card custom-card p-5 text-center shadow-sm">
                    <span class="icon-box">⏳</span>
                    <h4 class="card-title">Arsip Riwayat</h4>
                    <p class="card-text">Catatan Peminjaman</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="/" class="text-decoration-none">
                <div class="card custom-card card-logout p-5 text-center shadow-sm">
                    <span class="icon-box">🚪</span>
                    <h4 class="card-title">Keluar Sesi</h4>
                    <p class="card-text">Selesaikan Akses</p>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center text-muted mt-5">
            <hr style="width: 10%; margin: 20px auto; border-top: 2px solid #b8926a;">
            <small style="letter-spacing: 2px;">EST. 2024 - SISTEM PERPUSTAKAAN DIGITAL</small>
        </div>
    </div>
</div>

</body>
</html>