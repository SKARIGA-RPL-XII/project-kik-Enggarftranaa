<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori | Treasure Library</title>
    
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
            --sidebar-mini-width: 100px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR SYSTEM --- */
        .sidebar { 
            height: 100vh; background: var(--dark-sidebar); color: #fff; 
            position: fixed; width: var(--sidebar-width); z-index: 1000;
            padding: 30px 20px; display: flex; flex-direction: column;
            transition: var(--transition); overflow: hidden;
        }
        body.sidebar-mini .sidebar { width: var(--sidebar-mini-width); padding: 30px 15px; }

        .sidebar-brand {
            font-weight: 800; font-size: 1.2rem; color: white; text-decoration: none;
            display: flex; align-items: center; padding: 10px; margin-bottom: 40px; gap: 12px;
        }
        .brand-logo-box {
            width: 45px; height: 45px; background: var(--primary); border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;
        }
        body.sidebar-mini .sidebar-brand span:not(.brand-logo-box) { display: none; }

        .sidebar-category {
            font-size: 0.7rem; font-weight: 800; color: #4b5563; text-transform: uppercase;
            letter-spacing: 1.5px; margin: 25px 0 12px 15px; white-space: nowrap;
        }
        body.sidebar-mini .sidebar-category { display: none; }

        .sidebar a { 
            color: #94a3b8; display: flex; align-items: center; padding: 16px; 
            text-decoration: none; border-radius: 18px; margin-bottom: 8px; 
            font-size: 0.95rem; font-weight: 600; transition: var(--transition);
        }
        .sidebar a:hover { color: #fff; background: rgba(255,255,255,0.03); }
        .sidebar a.active { background: var(--primary); color: white; box-shadow: 0 10px 25px -5px var(--primary-glow); }

        .sidebar-icon { min-width: 35px; font-size: 1.3rem; display: flex; justify-content: center; align-items: center; margin-right: 15px; }
        body.sidebar-mini .sidebar-icon { margin-right: 0; min-width: 100%; }
        body.sidebar-mini .sidebar a span:not(.sidebar-icon) { display: none; }

        /* --- LAYOUT & CONTENT --- */
        .top-navbar {
            position: fixed; top: 0; right: 0; left: var(--sidebar-width);
            height: 85px; background: rgba(248, 250, 252, 0.9); backdrop-filter: blur(10px);
            display: flex; align-items: center; padding: 0 40px; z-index: 999;
            transition: var(--transition); border-bottom: 1px solid #eef2f6;
        }
        body.sidebar-mini .top-navbar { left: var(--sidebar-mini-width); }

        .main-content { margin-left: var(--sidebar-width); padding: 125px 40px 40px; transition: var(--transition); }
        body.sidebar-mini .main-content { margin-left: var(--sidebar-mini-width); }

        .sidebar-toggle { background: white; border: 1px solid #e2e8f0; width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }

        /* UI COMPONENTS */
        .table-container { 
            background: white; border-radius: 28px; padding: 35px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;
        }

        .category-icon {
            width: 45px; height: 45px; background: #eef2ff; color: #4e60ff;
            display: flex; align-items: center; justify-content: center;
            border-radius: 14px; font-weight: 800; font-size: 0.9rem;
        }

        .btn-modern { border-radius: 16px; padding: 12px 24px; font-weight: 700; transition: 0.3s; }
        .modal-content { border-radius: 32px; border: none; padding: 10px; }
        .form-control { border-radius: 14px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; }
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
            <a href="{{ route('admin.dashboard') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Dashboard</span>
            </a>
        </nav>

        <div class="sidebar-category">Management</div>
        <nav>
            <a href="/admin/user">
                <span class="sidebar-icon"><i class="fa-solid fa-users-viewfinder"></i></span>
                <span>Data Anggota</span>
            </a>
            <a href="{{ route('admin.buku.index') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-book"></i></span>
                <span>Koleksi Buku</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-layer-group"></i></span>
                <span>Kelola Kategori</span>
            </a>
        </nav>

        <div class="sidebar-category">Operation</div>
        <nav>
            <a href="{{ route('admin.scan') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span>
                <span>Scan Pinjam</span>
            </a>
            <a href="{{ route('admin.peminjaman.index') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                <span>Riwayat</span>
            </a>
        </nav>
    </div>
</aside>

<nav class="top-navbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="ms-4 fw-700 text-muted d-none d-md-block">
        Admin Panel <span class="mx-2 text-light-emphasis">/</span> <span class="text-dark fw-800">Kelola Kategori</span>
    </div>
</nav>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px; font-size: 2rem;">Kategori Buku</h2>
            <p class="text-muted fw-500">Organisir klasifikasi rak buku Anda dengan efisien.</p>
        </div>
        <button class="btn btn-primary btn-modern shadow" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        </script>
    @endif

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th class="ps-0">ID</th>
                        <th>NAMA KATEGORI</th>
                        <th class="text-center">JUMLAH KOLEKSI</th>
                        <th class="text-end pe-0">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td class="ps-0">
                            <div class="category-icon">#{{ $cat->id }}</div>
                        </td>
                        <td>
                            <div class="fw-800 text-dark mb-0">{{ $cat->nama }}</div>
                            <div class="text-muted small fw-600">Slug: {{ Str::slug($cat->nama) }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-light text-primary px-3 py-2 border fw-bold">
                                <i class="fa-solid fa-book me-1"></i> {{ $cat->buku_count ?? 0 }} Buku
                            </span>
                        </td>
                        <td class="text-end pe-0">
                            <form action="{{ route('admin.kategori.destroy', $cat->id) }}" method="POST" id="delete-form-{{ $cat->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-3 px-3 py-2" 
                                        onclick="confirmDelete('{{ $cat->id }}', '{{ $cat->nama }}')">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted fw-bold">Belum ada kategori tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-800">Buat Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted uppercase">NAMA KATEGORI</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Sains, Fiksi, Sejarah..." required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary btn-modern w-100 shadow">Simpan ke Database</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() { document.body.classList.toggle('sidebar-mini'); }

function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        text: `Seluruh buku di kategori "${name}" akan kehilangan relasi kategorinya!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
</body>
</html>