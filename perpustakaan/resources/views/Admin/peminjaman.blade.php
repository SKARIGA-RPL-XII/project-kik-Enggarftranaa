<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman | Admin Treasure</title>
    
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

        /* --- LAYOUT & TOP NAVBAR --- */
        .top-navbar {
            position: fixed; top: 0; right: 0; left: var(--sidebar-width);
            height: 85px; background: rgba(248, 250, 252, 0.9); backdrop-filter: blur(10px);
            display: flex; align-items: center; padding: 0 40px; z-index: 999;
            transition: var(--transition); border-bottom: 1px solid #eef2f6;
        }
        body.sidebar-mini .top-navbar { left: var(--sidebar-mini-width); }

        .main-content { margin-left: var(--sidebar-width); padding: 125px 40px 40px; transition: var(--transition); }
        body.sidebar-mini .main-content { margin-left: var(--sidebar-mini-width); }

        .sidebar-toggle { background: white; border: 1px solid #e2e8f0; width: 42px; height: 42px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }

        /* HEADER & SEARCH SECTION */
        .search-wrapper { position: relative; flex-grow: 1; max-width: 500px; }
        .search-wrapper i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        
        .search-input {
            width: 100%; height: 54px; padding: 12px 20px 12px 55px; border-radius: 18px;
            border: 1px solid #e2e8f0; background: white; font-weight: 600; transition: 0.3s;
            font-size: 0.95rem;
        }
        .search-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 10px 20px rgba(78, 96, 255, 0.1); }

        .btn-add-large {
            height: 54px; padding: 0 30px; border-radius: 18px; font-weight: 700;
            background: var(--primary); color: white; border: none; display: flex; align-items: center; gap: 12px;
            box-shadow: 0 8px 20px var(--primary-glow); text-decoration: none; transition: 0.3s;
        }
        .btn-add-large:hover { transform: translateY(-2px); color: white; box-shadow: 0 12px 25px var(--primary-glow); }

        /* TABLE STYLING */
        .table-container { background: white; border-radius: 28px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; }
        .user-avatar { width: 42px; height: 42px; border-radius: 12px; object-fit: cover; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

        .status-badge { padding: 6px 14px; border-radius: 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; display: inline-block; }
        .status-dipinjam { background: #e0e7ff; color: #4361ee; }
        .status-kembali { background: #f1f5f9; color: #64748b; }
        .status-telat { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }

        .btn-modern { border-radius: 12px; padding: 8px 18px; font-weight: 700; font-size: 0.8rem; transition: 0.3s; border: none; display: flex; align-items: center; gap: 6px; }
        .btn-selesai { background: #dcfce7; color: #15803d; }
        .btn-selesai:hover { background: #15803d !important; color: white !important; }
        .btn-delete { background: #fff5f5; color: var(--danger); border: 1px solid #fee2e2; }
        .btn-delete:hover { background: var(--danger); color: white; }

        .pulse-danger { animation: pulse-red 2s infinite; }
        @keyframes pulse-red { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }
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
            <a href="{{ route('admin.buku.index') }}">
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
            <a href="{{ route('admin.peminjaman.index') }}" class="active">
                <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                <span>Riwayat</span>
            </a>
        </nav>
    </div>

    <div style="margin-top: auto; padding: 20px 0;">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold d-flex align-items-center gap-3 p-3 w-100" onclick="confirmLogout()" style="border-radius: 18px;">
                <i class="fa-solid fa-power-off"></i> <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<nav class="top-navbar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="ms-4 fw-700 text-muted d-none d-md-block">
        Admin Panel <span class="mx-2 text-light-emphasis">/</span> <span class="text-dark fw-800">Log Transaksi</span>
    </div>
</nav>

<main class="main-content">
    <div class="row align-items-center mb-5">
        <div class="col-lg-4">
            <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px; font-size: 2rem;">Log Transaksi</h2>
            <p class="text-muted small mb-0">Total {{ count($peminjamans) }} aktivitas sirkulasi terdeteksi.</p>
        </div>
        
        <div class="col-lg-8">
            <div class="d-flex gap-3 justify-content-lg-end mt-3 mt-lg-0">
                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari nama anggota atau judul buku...">
                </div>

                <a href="{{ route('admin.scan') }}" class="btn-add-large">
                    <i class="fa-solid fa-plus fs-5"></i>
                    <span>Tambah</span>
                </a>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle" id="transactionTable">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th>ANGGOTA</th>
                        <th>BUKU</th>
                        <th>TENGGAT KEMBALI</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-end pe-0">KONTROL ADMIN</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($peminjamans as $p)
                    @php
                        $now = \Carbon\Carbon::now();
                        $tenggat = \Carbon\Carbon::parse($p->tgl_kembali);
                        $statusClean = strtoupper(trim($p->status));
                        $isSelesai = ($statusClean === 'DIKEMBALIKAN' || $statusClean === 'KEMBALI');
                        $isTerlambat = !$isSelesai && $now->gt($tenggat);
                        
                        $durasiTelat = "";
                        if($isTerlambat) {
                            $diff = $now->diff($tenggat);
                            if($diff->days > 0) $durasiTelat = $diff->days . " Hari " . $diff->h . " Jam";
                            else $durasiTelat = $diff->h . " Jam " . $diff->i . " Menit";
                        }
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?background=4e60ff&color=fff&name={{ urlencode($p->user->name) }}" class="user-avatar me-3">
                                <div>
                                    <div class="fw-700 text-dark mb-0 search-target-name">{{ $p->user->name }}</div>
                                    <div class="text-muted small" style="font-size: 0.7rem;">{{ $p->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-700 text-primary mb-0 search-target-book">{{ $p->buku->judul }}</div>
                            <div class="text-muted small">ID: BK-{{ $p->buku->id }}</div>
                        </td>
                        <td>
                            <div class="fw-600 {{ $isTerlambat ? 'text-danger pulse-danger' : '' }} mb-0">
                                {{ $tenggat->format('d M Y') }}
                                @if($isTerlambat) <i class="fa-solid fa-circle-exclamation ms-1"></i> @endif
                            </div>
                            <small class="{{ $isTerlambat ? 'text-danger' : 'text-muted' }} small">
                                {{ $tenggat->format('H:i') }} WIB
                            </small>
                        </td>
                        <td class="text-center">
                            @if($isSelesai)
                                <span class="status-badge status-kembali">DIKEMBALIKAN</span>
                            @elseif($isTerlambat)
                                <span class="status-badge status-telat">TERLAMBAT</span>
                                <div class="text-danger fw-800 mt-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-clock"></i> {{ $durasiTelat }}
                                </div>
                            @else
                                <span class="status-badge status-dipinjam">DIPINJAM</span>
                            @endif
                        </td>
                        <td class="text-end pe-0">
                            <div class="d-flex justify-content-end gap-2">
                                @if(!$isSelesai)
                                <form action="{{ route('admin.peminjaman.kembalikan', $p->id) }}" method="POST" id="return-form-{{ $p->id }}">
                                    @csrf
                                    <button type="button" class="btn-modern btn-selesai" onclick="confirmReturn('{{ $p->id }}', '{{ $p->buku->judul }}')">
                                        <i class="fa-solid fa-box-open"></i> Terima Fisik
                                    </button>
                                </form>
                                @else
                                    <span class="text-muted small fw-bold px-3"><i class="fa-solid fa-circle-check text-success"></i> Terverifikasi</span>
                                @endif

                                <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST" id="delete-form-{{ $p->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-modern btn-delete" onclick="confirmDelete('{{ $p->id }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function toggleSidebar() { document.body.classList.toggle('sidebar-mini'); }

    // FITUR SEARCH (JANGAN DIHAPUS)
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#transactionTable tbody tr');
        rows.forEach(row => {
            let nameText = row.querySelector('.search-target-name')?.textContent.toLowerCase() || "";
            let bookText = row.querySelector('.search-target-book')?.textContent.toLowerCase() || "";
            if (nameText.includes(filter) || bookText.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    // SWEETALERT CONFIRMATIONS
    function confirmReturn(id, judul) {
        Swal.fire({
            title: 'Verifikasi Fisik',
            text: "Pastikan buku '" + judul + "' sudah diterima dengan kondisi baik.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Ya, Terima Buku',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('return-form-' + id).submit();
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data riwayat ini akan hilang permanen dari database.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Hapus Permanen',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmLogout() {
        Swal.fire({
            title: 'Akhiri Sesi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4e60ff',
            confirmButtonText: 'Ya, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

</body>
</html>