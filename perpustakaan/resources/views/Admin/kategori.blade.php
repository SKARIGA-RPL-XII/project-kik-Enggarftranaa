<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori | Admin Treasure</title>
    
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

        .table-container {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: none;
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

        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .form-control {
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

        .rounded-24 { border-radius: 24px !important; }
        
        .category-icon {
            width: 40px;
            height: 40px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: bold;
        }
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
                <a href="{{ route('admin.buku.index') }}">📚 Data Buku</a>
                <a href="{{ route('admin.kategori.index') }}" class="active">🏷️ Kelola Kategori</a>
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
                    <h2 class="header-title mb-1">Kategori Buku</h2>
                    <p class="text-muted small">Organisir koleksi buku berdasarkan genre atau tipe.</p>
                </div>
                <button class="btn btn-primary btn-modern shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    + Kategori Baru
                </button>
            </div>

            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 2500,
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
                                <th class="ps-4" width="10%">ID</th>
                                <th>Nama Kategori</th>
                                <th class="text-center">Jumlah Buku</th>
                                <th class="text-end pe-4">Kontrol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                            <tr>
                                <td class="ps-4">
                                    <div class="category-icon">#{{ $cat->id }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $cat->nama }}</div>
                                    <div class="text-muted small">Slug: {{ Str::slug($cat->nama) }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-light text-primary px-3 py-2 border">
                                        {{ $cat->buku_count ?? 0 }} Buku
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light border rounded-3 fw-bold" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCategoryModal{{ $cat->id }}">
                                            Edit
                                        </button>
                                        
                                        <form action="{{ route('admin.kategori.destroy', $cat->id) }}" method="POST" id="delete-form-{{ $cat->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 fw-bold" 
                                                    onclick="confirmDelete('{{ $cat->id }}', '{{ $cat->nama }}')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editCategoryModal{{ $cat->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="fw-bold">Edit Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.kategori.update', $cat->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-muted">NAMA KATEGORI</label>
                                                    <input type="text" name="nama" value="{{ $cat->nama }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pb-4 px-4">
                                                <button type="submit" class="btn btn-primary btn-modern w-100">Update Kategori</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted small">Belum ada kategori yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA KATEGORI</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Fiksi, Sains, Sejarah" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-primary btn-modern w-100">Simpan Kategori</button>
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
        text: `Kategori "${name}" akan dihapus. Pastikan tidak ada buku yang terhubung dengan kategori ini.`,
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
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
</body>
</html>