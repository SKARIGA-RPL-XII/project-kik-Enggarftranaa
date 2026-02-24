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

        /* SIDEBAR (DESIGN AWAL) */
        .sidebar { 
            height: 100vh; background: var(--dark-sidebar); color: #fff; position: fixed; 
            width: var(--sidebar-width); z-index: 1000; padding: 30px 20px; display: flex;
            flex-direction: column; transition: var(--transition);
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
            color: #94a3b8; display: flex; align-items: center; padding: 16px; text-decoration: none; 
            border-radius: 18px; margin-bottom: 8px; font-size: 0.95rem; font-weight: 600;
            transition: var(--transition); white-space: nowrap;
        }
        .sidebar a:hover { color: #fff; background: rgba(255,255,255,0.03); }
        .sidebar a.active { background: var(--primary); color: white; box-shadow: 0 10px 25px -5px var(--primary-glow); }

        .sidebar-icon { min-width: 35px; font-size: 1.3rem; display: flex; justify-content: center; align-items: center; margin-right: 15px; }
        body.sidebar-mini .sidebar-icon { margin-right: 0; min-width: 100%; }
        body.sidebar-mini .sidebar a span:not(.sidebar-icon) { display: none; }

        /* CONTENT LAYOUT */
        .top-navbar {
            position: fixed; top: 0; right: 0; left: var(--sidebar-width); height: 85px;
            background: rgba(248, 250, 252, 0.9); backdrop-filter: blur(10px);
            display: flex; align-items: center; padding: 0 40px; z-index: 999;
            transition: var(--transition); border-bottom: 1px solid #eef2f6;
        }
        body.sidebar-mini .top-navbar { left: var(--sidebar-mini-width); }

        .main-content { margin-left: var(--sidebar-width); padding: 125px 40px 40px; transition: var(--transition); }
        body.sidebar-mini .main-content { margin-left: var(--sidebar-mini-width); }

        .sidebar-toggle {
            background: white; border: 1px solid #e2e8f0; width: 42px; height: 42px;
            border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center;
        }

        /* TABLE & CARDS */
        .table-container { 
            background: white; border-radius: 28px; padding: 35px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; 
        }
        
        .btn-action {
            width: 38px; height: 38px; border-radius: 12px; display: inline-flex;
            align-items: center; justify-content: center; border: 1px solid #e2e8f0;
            background: white; transition: 0.3s; cursor: pointer;
        }
        .btn-action:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

        .modal-content { border-radius: 28px; border: none; padding: 10px; }
        .form-control { border-radius: 14px; padding: 12px 18px; background: #f8fafc; border: 1px solid #e2e8f0; }
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
            <a href="/admin/dashboard">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-line"></i></span>
                <span>Dashboard</span>
            </a>
        </nav>

        <div class="sidebar-category">Management</div>
        <nav>
            <a href="/admin/user" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-users"></i></span>
                <span>Data Anggota</span>
            </a>
            <a href="/admin/buku">
                <span class="sidebar-icon"><i class="fa-solid fa-book-bookmark"></i></span>
                <span>Koleksi Buku</span>
            </a>
        </nav>

        <div class="sidebar-category">Operation</div>
        <nav>
            <a href="{{ route('admin.scan') }}">
                <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span>
                <span>Scan Pinjam</span>
            </a>
            <a href="/admin/peminjaman">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                <span>Riwayat</span>
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" class="btn btn-outline-danger w-100 border-0 fw-700 py-3" style="border-radius: 16px;" onclick="confirmLogout()">
                <i class="fa-solid fa-power-off me-2"></i> <span>Sign Out System</span>
            </button>
        </form>
    </div>
</aside>

<nav class="top-navbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="ms-4 fw-800 d-none d-md-block">Admin Panel / <span class="text-muted">Manajemen Anggota</span></div>
</nav>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-800 mb-1" style="letter-spacing: -1px;">Manajemen Anggota</h2>
            <p class="text-muted fw-500">Kelola dan pantau seluruh member perpustakaan</p>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative d-none d-lg-block" style="width: 320px;">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 20px; top: 18px; color: #94a3b8;"></i>
                <input type="text" id="memberSearch" class="form-control" placeholder="Cari nama atau email..." style="padding-left: 55px; height: 54px; border-radius: 18px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.03);">
            </div>
            <button class="btn btn-primary fw-800 px-4 shadow" style="border-radius: 18px; height: 54px;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa-solid fa-plus me-2"></i> Tambah Anggota
            </button>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle" id="userTable">
                <thead>
                    <tr class="text-muted small text-uppercase fw-800">
                        <th class="border-0 pb-3">Anggota</th>
                        <th class="border-0 pb-3">Email & Kredensial</th>
                        <th class="border-0 pb-3">Status</th>
                        <th class="border-0 pb-3">Bergabung</th>
                        <th class="border-0 pb-3 text-end">Opsi Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e60ff&color=fff&bold=true" class="rounded-4 me-3" width="45" height="45">
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
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-800" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-circle-check me-1"></i> AKTIF
                            </span>
                        </td>
                        <td><div class="fw-700 small">{{ $user->created_at->format('d M, Y') }}</div></td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('admin.user.reset', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <button type="button" class="btn-action" title="Reset Password" onclick="confirmReset(this)">
                                        <i class="fa-solid fa-key text-warning"></i>
                                    </button>
                                </form>
                                
                                <button class="btn-action" title="Edit Data" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </button>

                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-action" title="Hapus Anggota" onclick="confirmDelete(this)">
                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                    </button>
                                </form>
                            </div>
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
                                        <button type="submit" class="btn btn-primary fw-800 px-4" style="border-radius: 14px;">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted fw-600">Belum ada anggota terdaftar.</td></tr>
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
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn fw-700 text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-800 px-4" style="border-radius: 14px;">Daftarkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() { document.body.classList.toggle('sidebar-mini'); }

    // SCRIPT SEARCH ASLI ANDA
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
    });

    // ALERT SESSION SUCCESS ASLI ANDA
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

    // FUNGSI KONFIRMASI ASLI ANDA (SANGAT PENTING)
    function confirmReset(button) {
        Swal.fire({
            title: 'Reset Password?',
            text: "Password akan dikembalikan ke pengaturan default sistem.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4e60ff',
            confirmButtonText: 'Ya, Reset!',
            customClass: { popup: 'rounded-4' }
        }).then((result) => { if (result.isConfirmed) button.closest('form').submit(); });
    }

    function confirmDelete(button) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Seluruh riwayat pinjam anggota ini akan ikut hilang!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-4' }
        }).then((result) => { if (result.isConfirmed) button.closest('form').submit(); });
    }

    function confirmLogout() {
        Swal.fire({
            title: 'Keluar?',
            text: "Sesi admin akan diakhiri.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e60ff',
            confirmButtonText: 'Logout'
        }).then((result) => { if (result.isConfirmed) document.getElementById('logout-form').submit(); });
    }
</script>
</body>
</html>