<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku | Treasure Library</title>
    
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

        /* UI COMPONENTS */
        .search-wrapper { position: relative; width: 320px; }
        .search-wrapper i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .search-input { padding: 14px 20px 14px 50px !important; border: 1px solid #e2e8f0 !important; border-radius: 16px !important; }
        
        .table-container { 
            background: white; border-radius: 28px; padding: 35px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.02); border: 1px solid #f1f5f9;
        }
        .book-img { width: 50px; height: 72px; object-fit: cover; border-radius: 12px; box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        .badge-category { background: #eef2ff; color: #4e60ff; padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .sidebar-toggle { background: white; border: 1px solid #e2e8f0; width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .btn-modern { border-radius: 16px; padding: 12px 24px; font-weight: 700; transition: 0.3s; }
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
            <a href="{{ route('admin.buku.index') }}" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-book"></i></span>
                <span>Koleksi Buku</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}">
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
        Admin Panel <span class="mx-2 text-light-emphasis">/</span> <span class="text-dark fw-800">Koleksi Buku</span>
    </div>
</nav>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px; font-size: 2rem;">Inventaris Koleksi</h2>
            <p class="text-muted fw-500">Kelola buku dan pantau ketersediaan stok secara real-time.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="bookSearch" class="form-control search-input" placeholder="Cari buku...">
            </div>
            <button class="btn btn-primary btn-modern shadow" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="fa-solid fa-plus me-2"></i> Tambah Koleksi
            </button>
        </div>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        </script>
    @endif

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle" id="bookTable">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th>VISUAL</th>
                        <th>DETAIL BUKU</th>
                        <th>KATEGORI</th>
                        <th class="text-center">STOK</th>
                        <th class="text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                    <tr class="book-row">
                        <td><img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/50x70' }}" class="book-img"></td>
                        <td>
                            <div class="fw-800 text-dark book-title">{{ $item->judul }}</div>
                            <div class="text-muted small">Oleh: <span class="book-author">{{ $item->penulis }}</span></div>
                        </td>
                        <td><span class="badge-category book-category">{{ $item->kategori->nama ?? 'Umum' }}</span></td>
                        <td class="text-center fw-800 {{ $item->stok < 5 ? 'text-danger' : 'text-primary' }}">{{ $item->stok }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-light border fw-bold rounded-3 px-3 py-2" data-bs-toggle="modal" data-bs-target="#editBookModal{{ $item->id }}">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </button>
                                <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-3 px-3 py-2" onclick="confirmDelete('{{ $item->id }}', '{{ $item->judul }}')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="editBookModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header border-0 pt-4 px-4">
                                    <h5 class="fw-800">Perbarui Data Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.buku.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-8"><label class="form-label small fw-bold text-muted">JUDUL BUKU</label>
                                                <input type="text" name="judul" value="{{ $item->judul }}" class="form-control" required></div>
                                            <div class="col-md-4"><label class="form-label small fw-bold text-muted">KATEGORI</label>
                                                <select name="category_id" class="form-select">
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                                                    @endforeach
                                                </select></div>
                                            <div class="col-md-6"><label class="form-label small fw-bold text-muted">PENULIS</label>
                                                <input type="text" name="penulis" value="{{ $item->penulis }}" class="form-control" required></div>
                                            <div class="col-md-3"><label class="form-label small fw-bold text-muted">STOK</label>
                                                <input type="number" name="stok" value="{{ $item->stok }}" class="form-control" required></div>
                                            <div class="col-md-3"><label class="form-label small fw-bold text-muted">GANTI COVER</label>
                                                <input type="file" name="cover" class="form-control"></div>
                                            <div class="col-12"><label class="form-label small fw-bold text-muted">SINOPSIS</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="submit" class="btn btn-primary btn-modern w-100">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted fw-bold">Belum ada koleksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-800">Input Koleksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8"><label class="form-label small fw-bold text-muted">JUDUL LENGKAP</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: The Great Gatsby" required></div>
                        <div class="col-md-4"><label class="form-label small fw-bold text-muted">KATEGORI</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select></div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-muted">PENULIS</label>
                            <input type="text" name="penulis" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label small fw-bold text-muted">STOK AWAL</label>
                            <input type="number" name="stok" class="form-control" value="1" required></div>
                        <div class="col-md-3"><label class="form-label small fw-bold text-muted">UPLOAD COVER</label>
                            <input type="file" name="cover" class="form-control"></div>
                        <div class="col-12"><label class="form-label small fw-bold text-muted">SINOPSIS</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary btn-modern w-100">Simpan ke Database</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() { document.body.classList.toggle('sidebar-mini'); }

    document.getElementById('bookSearch').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('.book-row');
        rows.forEach(row => {
            let title = row.querySelector('.book-title').textContent.toLowerCase();
            let author = row.querySelector('.book-author').textContent.toLowerCase();
            row.style.display = (title.includes(searchValue) || author.includes(searchValue)) ? "" : "none";
        });
    });

    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Hapus Koleksi?',
            text: `Buku "${title}" akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
        })
    }
</script>
</body>
</html>