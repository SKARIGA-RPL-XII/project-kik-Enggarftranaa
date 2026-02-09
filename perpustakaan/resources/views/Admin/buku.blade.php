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
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
        }

        /* SIDEBAR */
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
        
        /* SEARCH BAR */
        .search-wrapper {
            position: relative;
            width: 320px;
        }
        .search-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .search-input {
            padding: 14px 20px 14px 50px !important;
            border: none !important;
            background: white !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
            border-radius: 16px !important;
        }

        /* TABLE & UI ENHANCEMENT */
        .table-container { 
            background: white; 
            border-radius: 30px; 
            padding: 35px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .book-img {
            width: 50px; height: 72px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .badge-category {
            background: #eef2ff;
            color: #4e60ff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .btn-modern { border-radius: 16px; padding: 12px 24px; font-weight: 700; transition: 0.3s; }
        
        .modal-content { border-radius: 32px; border: none; padding: 10px; }
        .form-control, .form-select { border-radius: 14px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; }
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
            <a href="{{ route('admin.buku.index') }}" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-book-bookmark"></i></span> Koleksi Buku
            </a>
            <a href="{{ route('admin.kategori.index') }}">
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
            <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px; font-size: 2rem;">Inventaris Koleksi</h2>
            <p class="text-muted fw-500">Kelola buku dan pantau ketersediaan stok secara real-time.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="bookSearch" class="form-control search-input" placeholder="Cari judul, penulis, atau kategori...">
            </div>

            <button class="btn btn-primary btn-modern shadow" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="fa-solid fa-plus me-2"></i> Tambah Koleksi Baru
            </button>
        </div>
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
            <table class="table align-middle" id="bookTable">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th class="ps-0">VISUAL</th>
                        <th>DETAIL BUKU</th>
                        <th>KATEGORI</th>
                        <th class="text-center">STOK</th>
                        <th class="text-end pe-0">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                    <tr class="book-row">
                        <td class="ps-0">
                            <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/50x70' }}" class="book-img">
                        </td>
                        <td>
                            <div class="fw-800 text-dark mb-0 book-title">{{ $item->judul }}</div>
                            <div class="text-muted small fw-600">Oleh: <span class="book-author">{{ $item->penulis }}</span></div>
                        </td>
                        <td>
                            <span class="badge-category book-category">{{ $item->kategori->nama ?? 'Umum' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-800 {{ $item->stok < 5 ? 'text-danger' : 'text-primary' }}">{{ $item->stok }}</span>
                        </td>
                        <td class="text-end pe-0">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-light border fw-bold rounded-3 px-3 py-2" data-bs-toggle="modal" data-bs-target="#editBookModal{{ $item->id }}">
                                    <i class="fa-solid fa-pen-to-square me-1 text-primary"></i> Edit
                                </button>
                                
                                <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-3 px-3 py-2" 
                                            onclick="confirmDelete('{{ $item->id }}', '{{ $item->judul }}')">
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
                                        <button type="submit" class="btn btn-primary btn-modern w-100 shadow">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr id="empty-row"><td colspan="5" class="text-center py-5 text-muted fw-bold">Belum ada koleksi di rak perpustakaan.</td></tr>
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
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi singkat buku..."></textarea></div>
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
// FUNGSI PENCARIAN BUKU
document.getElementById('bookSearch').addEventListener('keyup', function() {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('.book-row');
    let matchFound = false;

    rows.forEach(row => {
        let title = row.querySelector('.book-title').textContent.toLowerCase();
        let author = row.querySelector('.book-author').textContent.toLowerCase();
        let category = row.querySelector('.book-category').textContent.toLowerCase();

        if (title.includes(searchValue) || author.includes(searchValue) || category.includes(searchValue)) {
            row.style.display = "";
            matchFound = true;
        } else {
            row.style.display = "none";
        }
    });

    // Menampilkan pesan jika tidak ada hasil
    let existingNoResult = document.getElementById('no-search-results');
    if (!matchFound && searchValue !== "") {
        if (!existingNoResult) {
            let tbody = document.querySelector('#bookTable tbody');
            let tr = document.createElement('tr');
            tr.id = 'no-search-results';
            tr.innerHTML = `<td colspan="5" class="text-center py-5 text-muted fw-600">Buku dengan kata kunci "${searchValue}" tidak ditemukan.</td>`;
            tbody.appendChild(tr);
        }
    } else {
        if (existingNoResult) existingNoResult.remove();
    }
});

function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Koleksi?',
        text: `Buku "${title}" akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-24' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
</body>
</html>