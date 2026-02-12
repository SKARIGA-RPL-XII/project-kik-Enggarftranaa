<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Anggota | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root { 
            --primary: #4e60ff; 
            --primary-glow: rgba(78, 96, 255, 0.35);
            --dark-sidebar: #111827; 
            --bg-light: #f8fafc; 
            --danger: #ef4444; 
            --sidebar-width: 280px;
            --sidebar-mini-width: 100px; /* Sedikit lebih lebar agar ikon nyaman */
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR CUSTOM (Sesuai Gambar) --- */
        .sidebar { 
            height: 100vh; 
            background: var(--dark-sidebar); 
            color: #fff; 
            position: fixed; 
            width: var(--sidebar-width); 
            z-index: 1000;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            overflow: hidden;
        }

        body.sidebar-mini .sidebar {
            width: var(--sidebar-mini-width);
            padding: 30px 15px;
        }

        /* Logo Branding */
        .sidebar-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 40px;
            gap: 12px;
        }
        
        .brand-logo-box {
            width: 45px;
            height: 45px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        body.sidebar-mini .sidebar-brand span:not(.brand-logo-box) { display: none; }
        body.sidebar-mini .sidebar-brand { justify-content: center; padding: 10px 0; }

        /* Menu Categories */
        .sidebar-category {
            font-size: 0.7rem;
            font-weight: 800;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 12px 15px;
            white-space: nowrap;
        }
        body.sidebar-mini .sidebar-category { display: none; }

        /* Sidebar Nav Links */
        .sidebar-menu { flex-grow: 1; }

        .sidebar a { 
            color: #94a3b8; 
            display: flex; 
            align-items: center; 
            padding: 16px; 
            text-decoration: none; 
            border-radius: 18px; 
            margin-bottom: 8px; 
            font-size: 0.95rem; 
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
        }

        .sidebar a:hover { color: #fff; background: rgba(255,255,255,0.03); }

        .sidebar a.active { 
            background: var(--primary); 
            color: white; 
            box-shadow: 0 10px 25px -5px var(--primary-glow); 
        }

        .sidebar-icon { 
            min-width: 35px;
            font-size: 1.3rem; 
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }

        body.sidebar-mini .sidebar-icon { margin-right: 0; min-width: 100%; }
        body.sidebar-mini .sidebar a { justify-content: center; padding: 18px 0; }
        body.sidebar-mini .sidebar a span:not(.sidebar-icon) { display: none; }

        /* Sign Out Button */
        .sidebar-footer { padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .btn-signout {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            padding: 15px;
            border-radius: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }
        .btn-signout:hover { background: var(--danger); color: white; }
        body.sidebar-mini .btn-signout { justify-content: center; }
        body.sidebar-mini .btn-signout span:not(.sidebar-icon) { display: none; }

        /* --- LAYOUT ADJUSTMENTS --- */
        .top-navbar {
            position: fixed;
            top: 0; right: 0; left: var(--sidebar-width);
            height: 85px;
            background: rgba(248, 250, 252, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            padding: 0 40px;
            z-index: 999;
            transition: var(--transition);
            border-bottom: 1px solid #eef2f6;
        }
        body.sidebar-mini .top-navbar { left: var(--sidebar-mini-width); }

        .main-content { 
            margin-left: var(--sidebar-width); 
            padding: 125px 40px 40px; 
            transition: var(--transition); 
        }
        body.sidebar-mini .main-content { margin-left: var(--sidebar-mini-width); }

        .sidebar-toggle {
            background: white; border: 1px solid #e2e8f0; width: 42px; height: 42px;
            border-radius: 12px; cursor: pointer; color: var(--dark-sidebar);
            display: flex; align-items: center; justify-content: center;
        }

        /* --- DATA TABLE & MODAL (Preserved) --- */
        .table-container { 
            background: white; border-radius: 28px; padding: 35px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <a href="#" class="sidebar-brand">
        <span class="brand-logo-box"><i class="fa-solid fa-record-vinyl"></i></span>
        <span>TREASURE<span style="color:var(--primary)">LIB</span></span>
    </a>

    <div class="sidebar-menu">
        <div class="sidebar-category">Analytics</div>
        <nav>
            <a href="/admin/dashboard">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Dashboard</span>
            </a>
        </nav>

        <div class="sidebar-category">Management</div>
        <nav>
            <a href="/admin/user" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-users-viewfinder"></i></span>
                <span>Data Anggota</span>
            </a>
            <a href="/admin/buku">
                <span class="sidebar-icon"><i class="fa-solid fa-book"></i></span>
                <span>Koleksi Buku</span>
            </a>
        </nav>

        <div class="sidebar-category">Operation</div>
        <nav>
            <a href="{{ route('admin.scan') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span>
                <span>Scan Pinjam</span>
            </a>
            <a href="/admin/peminjaman">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                <span>Riwayat</span>
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" class="btn-signout" onclick="confirmLogout()">
                <span class="sidebar-icon"><i class="fa-solid fa-power-off"></i></span>
                <span>Sign Out System</span>
            </button>
        </form>
    </div>
</aside>

<nav class="top-navbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="ms-4 fw-700 text-muted d-none d-md-block">
        Admin Panel <span class="mx-2 text-light-emphasis">/</span> <span class="text-dark fw-800">Manajemen Anggota</span>
    </div>
</nav>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-800 mb-1" style="letter-spacing: -1px;">Manajemen Anggota</h2>
            <p class="text-muted fw-500">Kelola kredensial dan status member aktif</p>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative d-none d-lg-block" style="width: 300px;">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 20px; top: 18px; color: #94a3b8;"></i>
                <input type="text" id="memberSearch" class="form-control" placeholder="Cari nama anggota..." 
                       style="padding: 15px 15px 15px 55px; border-radius: 18px; border: 1px solid #e2e8f0; background: white;">
            </div>

            <button class="btn btn-primary px-4 fw-800 shadow-sm" style="border-radius: 18px;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa-solid fa-plus me-2"></i> Tambah Member
            </button>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle" id="userTable">
                <thead>
                    <tr class="text-muted small text-uppercase fw-800">
                        <th class="border-0 pb-3">Anggota</th>
                        <th class="border-0 pb-3">Kontak & Email</th>
                        <th class="border-0 pb-3">Status</th>
                        <th class="border-0 pb-3">Tanggal Join</th>
                        <th class="border-0 pb-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e60ff&color=fff&bold=true" class="rounded-4 me-3" width="45">
                                <div>
                                    <div class="fw-800 text-dark member-name">{{ $user->name }}</div>
                                    <small class="text-muted">ID-{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="small fw-600 member-email">{{ $user->email }}</td>
                        <td><span class="badge bg-success-subtle text-success rounded-pill px-3 py-2" style="font-size: 10px;">AKTIF</span></td>
                        <td class="small fw-600 text-muted">{{ $user->created_at->format('d M, Y') }}</td>
                        <td class="text-end">
                            <button class="btn btn-light btn-sm rounded-3 shadow-sm border" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}">
                                <i class="fa-solid fa-pen-to-square text-primary"></i>
                            </button>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-light btn-sm rounded-3 shadow-sm border ms-1" onclick="confirmDelete(this)">
                                    <i class="fa-solid fa-trash-can text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5">Tidak ada data ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle Sidebar Function
    function toggleSidebar() {
        document.body.classList.toggle('sidebar-mini');
    }

    // SweetAlert Logout
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar Sistem?',
            text: "Pastikan semua pekerjaan Anda telah disimpan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4e60ff',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Logout',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('logout-form').submit();
        });
    }

    // Live Search
    document.getElementById('memberSearch').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            let name = row.querySelector('.member-name').textContent.toLowerCase();
            let email = row.querySelector('.member-email').textContent.toLowerCase();
            row.style.display = (name.includes(val) || email.includes(val)) ? "" : "none";
        });
    });

    // Confirm Delete
    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus Member?',
            text: "Data yang dihapus tidak dapat dipulihkan!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus'
        }).then((res) => { if (res.isConfirmed) btn.closest('form').submit(); });
    }
</script>

</body>
</html>