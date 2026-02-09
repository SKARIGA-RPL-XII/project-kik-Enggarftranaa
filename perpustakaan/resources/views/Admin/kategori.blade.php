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
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
        }

        /* SIDEBAR IDENTIK */
        .sidebar { 
            height: 100vh; 
            background: var(--dark-sidebar); 
            color: #fff; 
            position: fixed; 
            width: 280px; 
            z-index: 1000;
            padding: 40px 24px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0 10px 40px;
            letter-spacing: 1px;
        }
        .sidebar-brand span { color: #4e60ff; }

        .sidebar-category {
            font-size: 0.75rem;
            font-weight: 700;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 20px 0 12px 12px;
        }

        .sidebar-menu { flex-grow: 1; }

        .sidebar a { 
            color: #94a3b8; 
            display: flex; 
            align-items: center; 
            padding: 16px 20px; 
            text-decoration: none; 
            border-radius: 16px; 
            margin-bottom: 4px; 
            font-size: 0.95rem; 
            font-weight: 600;
            transition: 0.3s; 
        }

        .sidebar a:hover { color: #fff; background: rgba(255,255,255,0.02); }

        .sidebar a.active { 
            background: var(--primary); 
            color: white; 
            box-shadow: 0 10px 20px -5px var(--primary-glow); 
        }

        .sidebar-icon { 
            width: 28px; 
            font-size: 1.15rem; 
            margin-right: 12px; 
            display: flex;
            justify-content: center;
        }

        .sidebar-footer { margin-top: auto; padding: 10px; }

        .btn-signout {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-signout:hover { background: var(--danger); color: white; }

        /* CONTENT AREA */
        .main-content { margin-left: 280px; padding: 50px; }

        /* TABLE & UI ENHANCEMENT */
        .table-container { 
            background: white; 
            border-radius: 30px; 
            padding: 35px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .category-icon {
            width: 45px; height: 45px;
            background: #eef2ff;
            color: #4e60ff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-weight: 800;
            font-size: 0.9rem;
        }

        .btn-modern { border-radius: 16px; padding: 12px 24px; font-weight: 700; transition: 0.3s; }
        
        .modal-content { border-radius: 32px; border: none; padding: 10px; }
        .form-control { border-radius: 14px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>

<aside class="sidebar">
    <a href="#" class="sidebar-brand">
        TREASURE<span>LIB</span>
    </a>

    <div class="sidebar-menu">
        <div class="sidebar-category">Analytics</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-line"></i></span> Dashboard
            </a>
        </nav>

        <div class="sidebar-category">Management</div>
        <nav>
            <a href="/admin/user">
                <span class="sidebar-icon"><i class="fa-solid fa-users"></i></span> Data Anggota
            </a>
            <a href="{{ route('admin.buku.index') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-book-bookmark"></i></span> Koleksi Buku
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-layer-group"></i></span> Kelola Kategori
            </a>
        </nav>

        <div class="sidebar-category">Operation</div>
        <nav>
            <a href="{{ route('admin.scan') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span> Scan Pinjam
            </a>
            <a href="#">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span> Riwayat
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn-signout">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out System
            </button>
        </form>
    </div>
</aside>

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