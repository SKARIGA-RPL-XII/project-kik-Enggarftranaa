<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Panel | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --primary-blue: #4361ee;
            --sidebar-dark: #0f172a;
            --surface-white: #ffffff;
            --body-bg: #f8fafc;
            --text-main: #1e293b;
            --text-soft: #64748b;
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        /* SIDEBAR MODERN */
        .sidebar {
            height: 100vh;
            background: var(--sidebar-dark);
            position: fixed;
            width: var(--sidebar-width);
            z-index: 1000;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-header { padding: 40px 30px; }

        .sidebar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
            letter-spacing: -1.5px;
        }
        .sidebar-brand span { color: var(--primary-blue); }

        .sidebar-menu { padding: 10px 20px; }

        .menu-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.15em;
            margin: 25px 0 10px 15px;
        }

        .sidebar a {
            color: #94a3b8;
            display: flex;
            align-items: center;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 14px;
            margin-bottom: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: white;
            background: rgba(255,255,255,0.03);
        }

        .sidebar a.active {
            background: var(--primary-blue);
            color: white;
            box-shadow: 0 10px 20px -5px rgba(67, 97, 238, 0.4);
        }

        .sidebar-icon { width: 28px; font-size: 1.1rem; }

        /* MAIN CONTENT */
        .main-content { margin-left: var(--sidebar-width); padding: 40px 50px; }

        /* STAT CARDS */
        .stat-card {
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            background: white;
            padding: 24px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.04); }

        .stat-icon {
            width: 54px; height: 54px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-right: 16px;
        }

        .stat-info h6 { font-size: 0.75rem; font-weight: 700; color: var(--text-soft); margin-bottom: 2px; text-transform: uppercase; }
        .stat-info h3 { font-weight: 800; margin-bottom: 0; color: #0f172a; }

        /* TABLE */
        .table-container { 
            background: white; 
            border-radius: 24px; 
            padding: 24px;
            border: 1px solid #f1f5f9;
        }

        .table thead th {
            background: #f8fafc;
            padding: 15px;
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 800;
            color: #64748b;
            border: none;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.65rem;
        }

        /* LOGOUT BUTTON */
        .sidebar-footer { padding: 25px; position: absolute; bottom: 0; width: 100%; }
        .btn-logout {
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.1);
            border-radius: 14px;
            padding: 12px;
            font-weight: 700;
            font-size: 0.85rem;
            width: 100%;
            transition: 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-logout:hover { background: #ef4444; color: white; box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3); }

        .bg-soft-blue { background: #eef2ff; color: #4361ee; }
        .bg-soft-emerald { background: #ecfdf5; color: #10b981; }
        .bg-soft-amber { background: #fffbeb; color: #d97706; }
    </style>
</head>
<body>

<aside class="sidebar d-none d-md-block">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">TREASURE<span>LIB</span></a>
    </div>
    
    <div class="sidebar-menu">
        <div class="menu-label">Analytics</div>
        <nav>
            <a href="/admin/dashboard" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-line"></i></span> Dashboard
            </a>
            
            <div class="menu-label">Management</div>
            <a href="/admin/user">
                <span class="sidebar-icon"><i class="fa-solid fa-user-group"></i></span> Data Anggota
            </a>
            <a href="/admin/buku">
                <span class="sidebar-icon"><i class="fa-solid fa-book-bookmark"></i></span> Koleksi Buku
            </a>
            
            <div class="menu-label">Operation</div>
            <a href="/admin/scan">
                <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span> Scan Pinjam
            </a>
            <a href="/admin/peminjaman">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span> Riwayat
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <button type="button" class="btn-logout" onclick="confirmLogout()">
            <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out System
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px;">Dashboard Overview</h2>
            <p class="text-muted small mb-0">Selamat datang kembali di Enterprise Panel.</p>
        </div>
        <div class="d-flex align-items-center bg-white p-3 rounded-4 border shadow-sm">
            <i class="fa-solid fa-calendar text-primary me-2"></i>
            <span class="fw-bold small">Jumat, 06 Februari 2026</span>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-soft-blue"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info"><h6>Total Anggota</h6><h3>1,240</h3></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-soft-emerald"><i class="fa-solid fa-book"></i></div>
                <div class="stat-info"><h6>Koleksi Buku</h6><h3>3,502</h3></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-soft-amber"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <div class="stat-info"><h6>Sedang Dipinjam</h6><h3>452</h3></div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-800 mb-0">Aktivitas Terbaru</h5>
            <a href="/admin/peminjaman" class="btn btn-light btn-sm fw-bold px-3">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Waktu</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="fw-bold">Andi Wibowo</div>
                            <small class="text-muted">ID: T-882</small>
                        </td>
                        <td>
                            <div class="fw-600 text-primary">Laravel Deep Dive</div>
                        </td>
                        <td><small class="fw-bold text-dark">24 Jan, 14:30</small></td>
                        <td class="text-center">
                            <span class="badge-status bg-soft-emerald">BERHASIL</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form langsung tanpa alert tambahan
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>

</body>
</html>