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
            --success: #10b981;
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
            opacity: 0.9;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 10px;
        }

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
        .btn-signout:hover {
            background: var(--danger);
            color: white;
        }

        /* CONTENT AREA */
        .main-content { margin-left: 280px; padding: 50px; }
        .header-title { font-weight: 800; letter-spacing: -1px; }

        /* SEARCH BAR CUSTOM */
        .search-container {
            position: relative;
            width: 320px;
        }
        .search-container i {
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

        /* TABLE ENHANCEMENT */
        .table-container { 
            background: white; 
            border-radius: 30px; 
            padding: 35px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .table thead th {
            background: #f8fafc;
            border: none;
            padding: 15px 20px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
        }

        .table tbody td { padding: 20px; border-bottom: 1px solid #f1f5f9; }
        .avatar-img { width: 45px; height: 45px; border-radius: 14px; object-fit: cover; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .badge-status { padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; }

        /* ACTION BUTTONS */
        .btn-action { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; transition: 0.2s; border: none; background: #f1f5f9; color: #64748b; text-decoration: none; }
        .btn-action:hover { transform: translateY(-3px); color: white; }
        .btn-edit:hover { background: var(--primary); box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3); }
        .btn-reset:hover { background: #f59e0b; box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3); }
        .btn-delete:hover { background: var(--danger); box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3); }
        .btn-add { background: var(--primary); border: none; padding: 14px 28px; border-radius: 16px; font-weight: 700; transition: 0.3s; }
        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3); background: #3651d1; }
        
        .modal-content { border-radius: 32px; border: none; padding: 15px; }
        .form-control { border-radius: 14px; padding: 14px 18px; border: 1px solid #e2e8f0; background: #f8fafc; }
    </style>
</head>
<body>

<aside class="sidebar d-none d-md-block">
    <a href="#" class="sidebar-brand">
        TREASURE<span>LIB</span>
    </a>

    <div class="sidebar-menu">
        <div class="sidebar-category">Analytics</div>
        <nav>
            <a href="/admin/dashboard">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-line"></i></span> Dashboard
            </a>
        </nav>

        <div class="sidebar-category">Management</div>
        <nav>
            <a href="/admin/user" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-users"></i></span> Data Anggota
            </a>
            <a href="/admin/buku">
                <span class="sidebar-icon"><i class="fa-solid fa-book-bookmark"></i></span> Koleksi Buku
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
        <form action="#" method="POST"> <button type="submit" class="btn-signout">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out System
            </button>
        </form>
    </div>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="header-title mb-1">Manajemen Anggota</h2>
            <p class="text-muted fw-500">Kelola dan pantau seluruh member perpustakaan</p>
        </div>
        
        <div class="d-flex gap-3">
            <div class="search-container d-none d-lg-block">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="memberSearch" class="form-control search-input" placeholder="Cari nama atau email...">
            </div>

            <button class="btn btn-primary btn-add shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa-solid fa-plus me-2"></i> Tambah Anggota Baru
            </button>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle" id="userTable">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Email & Kredensial</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th class="text-end">Opsi Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e60ff&color=fff&bold=true" class="avatar-img me-3">
                                <div>
                                    <div class="fw-800 text-dark member-name">{{ $user->name }}</div>
                                    <small class="text-muted fw-600">ID-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-600 small member-email">{{ $user->email }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;"><i class="fa-solid fa-shield-check me-1"></i> Terverifikasi</div>
                        </td>
                        <td>
                            <span class="badge-status" style="background: #ecfdf5; color: #10b981;">
                                <i class="fa-solid fa-circle-check me-1"></i> AKTIF
                            </span>
                        </td>
                        <td>
                            <div class="fw-700 small">{{ $user->created_at->format('d M, Y') }}</div>
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.user.reset', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <button type="button" class="btn-action btn-reset" title="Reset Password" onclick="confirmReset(this)">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                            </form>
                            
                            <button class="btn-action btn-edit mx-1" title="Edit Data" 
                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-action btn-delete" title="Hapus Anggota" onclick="confirmDelete(this)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header border-0 pb-0">
                                    <h4 class="fw-800">Perbarui Profil</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label class="form-label small fw-800 text-uppercase">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-800 text-uppercase">Alamat Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn fw-700 text-muted" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary btn-add px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa-solid fa-user-slash fa-3x mb-3 opacity-20"></i>
                            <p class="text-muted fw-600">Belum ada anggota yang terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h4 class="fw-800">Registrasi Anggota</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label small fw-800 text-uppercase">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-800 text-uppercase">Email Anggota</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-800 text-uppercase">Password Sementara</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <p class="text-muted small fw-600 mt-2">Sistem akan secara otomatis mengirimkan detail akun setelah disimpan.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn fw-700 text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-add px-4">Daftarkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // FUNGSI PENCARIAN (SEARCH)
    document.getElementById('memberSearch').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('.user-row');
        let matchFound = false;

        rows.forEach(row => {
            let name = row.querySelector('.member-name').textContent.toLowerCase();
            let email = row.querySelector('.member-email').textContent.toLowerCase();

            if (name.includes(searchValue) || email.includes(searchValue)) {
                row.style.display = "";
                matchFound = true;
            } else {
                row.style.display = "none";
            }
        });

        // Tampilkan pesan jika tidak ada data ditemukan
        let existingNoData = document.getElementById('no-search-results');
        if (!matchFound) {
            if (!existingNoData) {
                let tbody = document.querySelector('#userTable tbody');
                let tr = document.createElement('tr');
                tr.id = 'no-search-results';
                tr.innerHTML = `<td colspan="5" class="text-center py-5 text-muted fw-600">Tidak ada anggota yang cocok dengan "${searchValue}"</td>`;
                tbody.appendChild(tr);
            }
        } else {
            if (existingNoData) existingNoData.remove();
        }
    });

    // Konfigurasi SweetAlert Global
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    @if(session('success'))
        Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
    @endif

    function confirmDelete(button) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Seluruh riwayat pinjam anggota ini akan ikut hilang!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Tetap!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-24' }
        }).then((result) => { if (result.isConfirmed) button.closest('form').submit(); });
    }

    function confirmReset(button) {
        Swal.fire({
            title: 'Reset Password?',
            text: "Password akan dikembalikan ke pengaturan default sistem.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            confirmButtonText: 'Ya, Reset!',
            customClass: { popup: 'rounded-24' }
        }).then((result) => { if (result.isConfirmed) button.closest('form').submit(); });
    }
</script>

</body>
</html>