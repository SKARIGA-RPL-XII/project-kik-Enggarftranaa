<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku | Admin Treasure</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            position: fixed;
            width: 16.6%;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 25px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar a {
            color: #a2a3b7;
            display: flex;
            align-items: center;
            padding: 14px 18px;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 12px;
            margin: 8px 15px;
            font-size: 0.9rem;
        }

        .sidebar a:hover, .sidebar a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 16.6%;
            padding: 40px;
        }

        .header-title {
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--dark-sidebar);
        }

        /* MODERN TABLE CARD */
        .table-container {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: none;
        }

        .book-img {
            width: 45px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .table thead th {
            background: #f8fafc;
            border: none;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            padding: 15px;
        }

        .badge-category {
            background: rgba(76, 201, 240, 0.1);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* MODAL & BUTTONS */
        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px;
            border-color: #e2e8f0;
            font-size: 0.9rem;
        }

        .btn-modern {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        /* SWEETALERT CUSTOMIZATION */
        .rounded-24 { border-radius: 24px !important; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar d-none d-md-block shadow">
            <div class="sidebar-header text-center">
                <span class="fw-bold fs-5">Treasure<span style="color:var(--accent)">Library</span></span>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('admin.buku.index') }}" class="active">📚 Data Buku</a>
                <a href="#">🏷️ Kelola Kategori</a>
            </div>
            <div style="position: absolute; bottom: 30px; width: 100%; padding: 0 15px;">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger w-100 btn-modern">Logout</button>
                </form>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="header-title mb-1">Inventaris Koleksi</h2>
                    <p class="text-muted small">Kelola buku dan ketersediaan stok perpustakaan.</p>
                </div>
                <button class="btn btn-primary btn-modern shadow-sm" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    + Tambah Koleksi
                </button>
            </div>

            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-24' }
                    });
                </script>
            @endif

            <div class="table-container shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Visual</th>
                                <th>Informasi Buku</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th class="text-end pe-4">Kontrol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku as $item)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/50x70' }}" class="book-img">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                    <div class="text-muted small">Oleh: {{ $item->penulis }}</div>
                                </td>
                                <td>
                                    <span class="badge-category">{{ $item->kategori->nama ?? 'Umum' }}</span>
                                </td>
                                <td class="text-center fw-bold text-primary">{{ $item->stok }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light border rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#editBookModal{{ $item->id }}">Edit</button>
                                        
                                        <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 fw-bold" 
                                                    onclick="confirmDelete('{{ $item->id }}', '{{ $item->judul }}')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editBookModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="fw-bold">Edit Koleksi Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.buku.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-8"><label class="form-label small fw-bold text-muted">JUDUL</label><input type="text" name="judul" value="{{ $item->judul }}" class="form-control" required></div>
                                                    <div class="col-md-4"><label class="form-label small fw-bold text-muted">KATEGORI</label>
                                                        <select name="category_id" class="form-select">
                                                            @foreach($categories as $cat)
                                                                <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6"><label class="form-label small fw-bold text-muted">PENULIS</label><input type="text" name="penulis" value="{{ $item->penulis }}" class="form-control" required></div>
                                                    <div class="col-md-3"><label class="form-label small fw-bold text-muted">STOK</label><input type="number" name="stok" value="{{ $item->stok }}" class="form-control" required></div>
                                                    <div class="col-md-3"><label class="form-label small fw-bold text-muted">GANTI COVER</label><input type="file" name="cover" class="form-control"></div>
                                                    <div class="col-12"><label class="form-label small fw-bold text-muted">DESKRIPSI</label><textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pb-4 px-4">
                                                <button type="submit" class="btn btn-primary btn-modern w-100">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted small">Belum ada koleksi tersedia di rak.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Input Koleksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8"><label class="form-label small fw-bold text-muted">JUDUL BUKU</label><input type="text" name="judul" class="form-control" placeholder="Contoh: Harry Potter" required></div>
                        <div class="col-md-4"><label class="form-label small fw-bold text-muted">KATEGORI</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-muted">PENULIS</label><input type="text" name="penulis" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label small fw-bold text-muted">STOK</label><input type="number" name="stok" class="form-control" value="1" required></div>
                        <div class="col-md-3"><label class="form-label small fw-bold text-muted">COVER</label><input type="file" name="cover" class="form-control"></div>
                        <div class="col-12"><label class="form-label small fw-bold text-muted">DESKRIPSI</label><textarea name="deskripsi" class="form-control" rows="3"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-primary btn-modern w-100">Simpan Koleksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Koleksi?',
        text: `Apakah Anda yakin ingin menghapus "${title}"? Data tidak dapat dikembalikan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4361ee',
        cancelButtonColor: '#e2e8f0',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-24',
            confirmButton: 'btn-modern py-2 px-4',
            cancelButton: 'btn-modern py-2 px-4 text-dark'
        },
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sedang Menghapus...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading() }
            });
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
</body>
</html>