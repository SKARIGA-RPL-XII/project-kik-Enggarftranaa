<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota | Treasure Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4361ee; --dark-sidebar: #1e1e2d; --bg-light: #f4f7fe; }
        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { height: 100vh; background: var(--dark-sidebar); color: #fff; position: fixed; width: 16.66667%; }
        .sidebar-menu { padding: 20px; }
        .sidebar a { color: #a2a3b7; display: flex; align-items: center; padding: 14px 18px; text-decoration: none; border-radius: 12px; margin-bottom: 8px; font-size: 0.9rem; }
        .sidebar a.active { background: var(--primary); color: white; }
        .main-content { margin-left: 16.66667%; padding: 40px; }
        .table-container { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .sidebar-icon { margin-right: 12px; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar">
            <div class="sidebar-menu mt-4">
                <nav>
                    <a href="/admin/dashboard"><span class="sidebar-icon">🏠</span> Dashboard</a>
                    <a href="/admin/user" class="active"><span class="sidebar-icon">👥</span> Data Anggota</a>
                    <a href="/admin/buku"><span class="sidebar-icon">📚</span> Koleksi Buku</a>
                    <a href="{{ route('admin.scan') }}"><span class="sidebar-icon">📸</span> Scan Peminjaman</a>
                </nav>
            </div>
        </div>

        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Manajemen Anggota</h2>
                <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    + Tambah Anggota
                </button>
            </div>

            <div class="table-container">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Profil</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Tanggal Bergabung</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle" width="40">
                            </td>
                            <td><div class="fw-bold">{{ $user->name }}</div><small class="text-muted">ID: #{{ $user->id }}</small></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <button class="btn btn-light btn-sm rounded-3 border">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold">Input Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Andi Wijaya" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email (Untuk Login)</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="andi@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password Default</label>
                        <input type="password" name="password" class="form-control rounded-3" required>
                        <small class="text-muted" style="font-size: 0.7rem;">Minimal 8 karakter. Berikan password ini ke anggota.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>