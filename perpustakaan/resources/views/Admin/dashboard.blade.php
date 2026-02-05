<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --accent: #4cc9f0;
            --dark-sidebar: #1e1e2d;
            --bg-light: #f4f7fe;
            --text-muted: #7e8299;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2b40;
        }

        /* SIDEBAR */
        .sidebar {
            height: 100vh;
            background: var(--dark-sidebar);
            color: #fff;
            padding: 0;
            position: fixed;
            width: 16.66667%;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 25px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar-brand span { color: var(--accent); }

        .sidebar-menu { padding: 20px; }

        .sidebar a {
            color: #a2a3b7;
            display: flex;
            align-items: center;
            padding: 14px 18px;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 12px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .sidebar-icon { margin-right: 12px; font-size: 1.1rem; }

        /* MAIN CONTENT */
        .main-content { margin-left: 16.66667%; padding: 40px; }

        .page-header { font-weight: 800; color: var(--dark-sidebar); letter-spacing: -1px; margin-bottom: 30px; }

        /* STAT CARDS */
        .stat-card {
            border: none; border-radius: 20px; background: #fff; padding: 25px;
            transition: 0.3s; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            display: flex; align-items: center;
        }

        .stat-card:hover { transform: translateY(-5px); }

        .stat-icon {
            width: 60px; height: 60px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-right: 20px;
        }

        .stat-info h6 { font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px; text-transform: uppercase; }
        .stat-info h3 { font-weight: 800; margin-bottom: 0; }

        .bg-light-primary { background: rgba(67, 97, 238, 0.1); color: var(--primary); }
        .bg-light-accent { background: rgba(76, 201, 240, 0.1); color: var(--accent); }
        .bg-light-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .bg-light-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

        /* TABLE */
        .table-container { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .badge-modern { padding: 8px 14px; border-radius: 10px; font-weight: 700; font-size: 0.7rem; }
        
        .sidebar-footer { padding: 20px; position: absolute; bottom: 0; width: 100%; }
        .btn-logout-admin { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; border-radius: 12px; padding: 12px; font-weight: 600; width: 100%; transition: 0.3s; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <div class="col-md-2 sidebar d-none d-md-block">
            <div class="sidebar-header text-center">
                <a href="#" class="sidebar-brand">Treasure<span>Library</span></a>
            </div>
            
            <div class="sidebar-menu">
                <small class="text-uppercase fw-bold text-muted mb-3 d-block" style="font-size: 0.65rem; letter-spacing: 2px; padding-left: 15px;">Main Menu</small>
                <nav>
                    <a href="/admin/dashboard" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><span class="sidebar-icon">🏠</span> Dashboard</a>
                    <a href="/admin/user"><span class="sidebar-icon">👥</span> Data Anggota</a>
                    <a href="/admin/buku"><span class="sidebar-icon">📚</span> Koleksi Buku</a>
                    
                    <a href="{{ route('admin.scan') }}" class="{{ Request::is('admin/scan') ? 'active' : '' }}">
                        <span class="sidebar-icon">📸</span> Scan Peminjaman
                    </a>
                    <a href="#"><span class="sidebar-icon">📊</span> Riwayat Peminjaman</a>
                </nav>
            </div>

            <div class="sidebar-footer">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-logout-admin">Keluar Panel</button>
                </form>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-header">Overview Dashboard</h2>
                <div class="text-muted small fw-bold">{{ now()->format('d F Y') }}</div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-light-primary">👥</div>
                        <div class="stat-info"><h6>Total Anggota</h6><h3>1,240</h3></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-light-accent">📚</div>
                        <div class="stat-info"><h6>Koleksi Buku</h6><h3>3,502</h3></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-light-success">🔄</div>
                        <div class="stat-info"><h6>Peminjaman</h6><h3>452</h3></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-light-danger">⚠️</div>
                        <div class="stat-info"><h6>Overdue</h6><h3>12</h3></div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Aktivitas Terkini</h4>
                    <button class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Lihat Semua</button>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Nama Peminjam</th>
                                <th>Judul Koleksi</th>
                                <th>Waktu Pinjam</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="fw-bold">Andi Wibowo</div><small class="text-muted">ID: T-882</small></td>
                                <td><div class="text-dark">Laravel Deep Dive</div><small class="text-muted">Rak: A-12</small></td>
                                <td>24 Jan 2026</td>
                                <td><span class="badge badge-modern bg-success text-white">AKTIF</span></td>
                                <td class="text-end"><button class="btn btn-light btn-sm fw-bold border">Kelola</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>