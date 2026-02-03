<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota | Treasure Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root { --primary: #4361ee; --dark-sidebar: #1e1e2d; --bg-light: #f4f7fe; --danger: #ef4444; }
        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { height: 100vh; background: var(--dark-sidebar); color: #fff; position: fixed; width: 16.66667%; z-index: 100; }
        .sidebar-menu { padding: 20px; }
        .sidebar a { color: #a2a3b7; display: flex; align-items: center; padding: 14px 18px; text-decoration: none; border-radius: 12px; margin-bottom: 8px; font-size: 0.9rem; transition: 0.3s; }
        .sidebar a:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .sidebar a.active { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2); }
        .main-content { margin-left: 16.66667%; padding: 40px; }
        .table-container { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .sidebar-icon { margin-right: 12px; }
        .modal-content { border-radius: 24px; border: none; overflow: hidden; }
        .modal-header { background: #f8f9fa; border-bottom: 1px solid #eee; }
        .form-control { border-radius: 12px; padding: 12px 16px; border: 1px solid #e2e8f0; background: #fff; transition: all 0.2s; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1); }
        .helper-text { font-size: 0.75rem; color: #64748b; margin-top: 5px; display: block; }
        .rounded-24 { border-radius: 24px !important; }
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.2s; border: 1px solid #eee; background: white; }
        .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
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
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
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
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle" width="40">
                            </td>
                            <td><div class="fw-bold">{{ $user->name }}</div><small class="text-muted">ID: #{{ $user->id }}</small></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.user.reset', $user->id) }}" method="POST" class="d-inline reset-form">
                                    @csrf @method('PUT')
                                    <button type="button" class="btn-action text-warning" title="Reset Password" onclick="confirmReset(this)">
                                        🔑
                                    </button>
                                </form>
                                <button class="btn-action text-primary mx-1" title="Edit Data" 
                                    data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}">
                                    ✏️
                                </button>
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-action text-danger" title="Hapus Anggota" onclick="confirmDelete(this)">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0 px-4 pt-4">
                                        <h5 class="fw-bold m-0">Edit Data Anggota</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body px-4 pt-3">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Alamat Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                <span class="helper-text">Mengubah email akan mengubah kredensial login anggota tersebut.</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Belum ada data anggota.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold m-0">Input Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 pt-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Andi Wijaya" value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email (Untuk Login)</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="andi@email.com" value="{{ old('email') }}">
                        <span class="helper-text">Email ini akan digunakan anggota untuk mengakses akun mereka.</span>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password Default</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        <span class="helper-text">Minimal 8 karakter. Berikan password ini ke anggota agar mereka bisa login pertama kali.</span>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

<script>
    // SweetAlert Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            customClass: { popup: 'rounded-24' }
        });
    @endif

    // Konfirmasi Hapus
    function confirmDelete(button) {
        Swal.fire({
            title: 'Hapus Anggota?',
            text: "Data yang dihapus tidak dapat dipulihkan kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-24' }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // Konfirmasi Reset Password
    function confirmReset(button) {
        Swal.fire({
            title: 'Reset Password?',
            text: "Password akan diatur ulang ke standar (contoh: 12345678). Beritahu anggota segera!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Reset Password',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-24' }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // Auto-open modal jika error validasi
    @if($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('modalTambah'));
        myModal.show();
    @endif
</script>

</body>
</html>