<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku | Admin Treasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; }
        .sidebar { height: 100vh; background: #1e293b; color: white; position: fixed; padding-top: 20px; z-index: 100; }
        .sidebar a { color: #cbd5e1; text-decoration: none; padding: 12px 20px; display: block; transition: 0.2s; }
        .sidebar a:hover, .sidebar a.active { background: #334155; color: #b8926a; border-left: 4px solid #b8926a; }
        .main-content { margin-left: 16.6%; padding: 40px; min-height: 100vh; }
        .card-table { border: none; border-radius: 0; border-top: 4px solid #b8926a; background: white; }
        .book-img { width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
        .header-title { font-family: 'Playfair Display', serif; color: #1e293b; font-size: 2rem; }
        .btn-dark { background: #1e293b; border: none; }
        .btn-dark:hover { background: #334155; }
        .badge { font-weight: 500; padding: 6px 10px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar shadow">
            <h4 class="text-center mb-4" style="color: #b8926a; font-family: 'Playfair Display', serif;">Treasure International School</h4>
            <a href="/admin/dashboard">🏠 Dashboard</a>
            <a href="/admin/buku" class="active">📚 Data Buku</a>
            <a href="#">📖 Peminjaman</a>
            <hr class="mx-3 opacity-25">
            <div class="px-3 mt-4">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm w-100 rounded-0">Logout</button>
                </form>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="header-title mb-1">Inventaris Buku</h2>
                    <p class="text-muted small">Kelola koleksi perpustakaan dan pantau ketersediaan stok.</p>
                </div>
                <button class="btn btn-dark rounded-0 px-4 py-2" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    <span class="me-1">+</span> Tambah Koleksi Baru
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card card-table shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4" width="80">Cover</th>
                                    <th>Informasi Buku</th>
                                    <th class="text-center">Stok</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buku as $item)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/50x70?text=No+Cover' }}" 
                                             class="book-img shadow-sm">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                        <div class="text-muted small">Oleh: {{ $item->penulis }}</div>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $item->stok }}</td>
                                    <td>
                                        @if($item->stok <= 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @elseif($item->stok < 5)
                                            <span class="badge bg-warning text-dark">Hampir Habis</span>
                                        @else
                                            <span class="badge bg-success bg-opacity-75">Tersedia</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-outline-secondary rounded-0">Edit</button>
                                            <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-0" 
                                                        onclick="return confirm('Hapus buku ini secara permanen?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                        <p class="text-muted">Belum ada koleksi buku yang terdaftar.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white rounded-0">
                <h5 class="modal-title font-playfair" id="addBookModalLabel">Input Koleksi Buku Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-uppercase text-muted">Judul Lengkap Buku</label>
                            <input type="text" name="judul" class="form-control rounded-0 border-secondary-subtle" 
                                   placeholder="Contoh: Laskar Pelangi" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control rounded-0 border-secondary-subtle" 
                                   placeholder="0" required min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Penulis</label>
                            <input type="text" name="penulis" class="form-control rounded-0 border-secondary-subtle" 
                                   placeholder="Nama penulis..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Upload Cover</label>
                            <input type="file" name="cover" class="form-control rounded-0 border-secondary-subtle" 
                                   accept="image/*">
                            <div class="form-text mt-1" style="font-size: 0.7rem;">Format yang disarankan: JPG/PNG, Max 2MB.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Sinopsis / Deskripsi</label>
                            <textarea name="deskripsi" class="form-control rounded-0 border-secondary-subtle" 
                                      rows="4" placeholder="Tuliskan deskripsi singkat mengenai isi buku ini..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4">
                    <button type="button" class="btn btn-secondary rounded-0 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark rounded-0 px-5 shadow-sm" 
                            style="border-left: 4px solid #b8926a;">Simpan Koleksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>