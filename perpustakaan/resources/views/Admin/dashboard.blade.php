<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Treasure International School</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --admin-sidebar: #1e293b; /* Slate Dark */
            --admin-accent: #b8926a;  /* Classic Gold */
            --admin-bg: #f8fafc;
        }

        body {
            background-color: var(--admin-bg);
            font-family: 'Inter', sans-serif;
            color: #334155;
        }

        /* SIDEBAR STYLE */
        .sidebar {
            height: 100vh;
            background: var(--admin-sidebar);
            color: #fff;
            padding: 30px 20px;
            position: fixed;
            border-right: 4px solid var(--admin-accent);
        }

        .sidebar h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            letter-spacing: 2px;
            color: var(--admin-accent);
            margin-bottom: 40px;
            text-align: center;
        }

        .sidebar .user-info {
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .sidebar a {
            color: #cbd5e1;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 6px;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        .sidebar a:hover {
            background: rgba(184, 146, 106, 0.2);
            color: var(--admin-accent);
            padding-left: 20px;
        }

        .sidebar a.active {
            background: var(--admin-accent);
            color: white;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 16.66667%; /* Offset for sidebar */
            padding: 40px;
        }

        .page-header {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--admin-sidebar);
            margin-bottom: 30px;
        }

        /* CARD STYLE */
        .card-box {
            border: none;
            border-radius: 0; /* Classic boxy style */
            background: #fff;
            border-top: 3px solid var(--admin-accent);
            transition: transform 0.3s;
        }

        .card-box:hover {
            transform: translateY(-5px);
        }

        .card-box h6 {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
        }

        .card-box h3 {
            font-weight: 700;
            color: var(--admin-sidebar);
        }

        /* TABLE STYLE */
        .custom-table {
            background: white;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .custom-table thead {
            background: var(--admin-sidebar);
            color: white;
        }

        .custom-table th {
            font-weight: 400;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 15px;
            border: none;
        }

        .badge {
            border-radius: 0;
            padding: 6px 12px;
            font-weight: 500;
        }

        /* LOGOUT BUTTON */
        .btn-logout {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #ef4444;
            border-color: #ef4444;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 sidebar d-none d-md-block">
            <h4>TREASURE<br><small>LIBRARY</small></h4>
            
            <div class="user-info text-center">
                <div class="mb-2">Logged in as:</div>
                <strong class="text-white">{{ auth()->user()->name ?? 'Administrator' }}</strong>
            </div>

            <nav>
                <a href="/admin/dashboard" class="active">🏠 Dashboard</a>
                <a href="/admin/user">👥 Data User</a>
                <a href="/admin/buku">📚 Data Buku</a>
                <a href="#">📖 Peminjaman</a>
                <a href="#">📊 Laporan</a>
            </nav>

            <div style="position: absolute; bottom: 30px; width: calc(100% - 40px);">
                <hr class="text-white-50">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-logout btn-sm w-100">
                        Keluar Sesi
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <h2 class="page-header">Dashboard</h2>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-4">
                        <h6>Total Anggota</h6>
                        <h3>120</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-4">
                        <h6>Koleksi Buku</h6>
                        <h3>350</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-4">
                        <h6>Sirkulasi Aktif</h6>
                        <h3>45</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-4" style="border-top-color: #ef4444;">
                        <h6>Lewat Jatuh Tempo</h6>
                        <h3 class="text-danger">8</h3>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="font-family: 'Playfair Display', serif;">Aktivitas Terkini</h4>
                    <button class="btn btn-sm btn-outline-secondary">Lihat Semua</button>
                </div>
                
                <div class="table-responsive custom-table">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="fw-bold">Andi</td>
                                <td class="text-muted">Laravel Untuk Pemula</td>
                                <td>20 Jan 2026</td>
                                <td><span class="badge bg-success">Dipinjam</span></td>
                                <td><a href="#" class="btn btn-sm btn-light border">Detail</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Sinta</td>
                                <td class="text-muted">Basis Data</td>
                                <td>18 Jan 2026</td>
                                <td><span class="badge bg-danger">Terlambat</span></td>
                                <td><a href="#" class="btn btn-sm btn-light border">Detail</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>