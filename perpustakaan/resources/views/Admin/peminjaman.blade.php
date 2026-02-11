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
            --primary: #4361ee;
            --accent: #4cc9f0;
            --dark-sidebar: #0f172a;
            --bg-light: #f8fafc;
            --danger: #ef4444;
            --success: #10b981;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            background: var(--dark-sidebar);
            color: #fff;
            position: fixed;
            width: 260px;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 30px 25px;
            background: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-align: center;
        }

        .sidebar a {
            color: #94a3b8;
            display: flex;
            align-items: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 14px;
            margin: 6px 15px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .sidebar a i { width: 25px; font-size: 1.1rem; }

        .sidebar a:hover, .sidebar a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
        }

        .main-content {
            margin-left: 260px;
            padding: 40px;
            min-height: 100vh;
        }

        /* HEADER & SEARCH SECTION */
        .search-wrapper {
            position: relative;
            flex-grow: 1;
            max-width: 500px;
        }

        .search-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-input {
            width: 100%;
            height: 54px; /* Disamakan dengan tinggi tombol */
            padding: 12px 20px 12px 55px;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            background: white;
            font-weight: 600;
            font-size: 0.95rem;
            transition: 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.1);
        }

        /* TOMBOL TAMBAH BESAR */
        .btn-add-large {
            height: 54px;
            padding: 0 30px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--primary);
            color: white;
            border: none;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.25);
            white-space: nowrap;
        }

        .btn-add-large:hover {
            background: #3651d1;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(67, 97, 238, 0.35);
            color: white;
        }

        /* TABLE STYLING */
        .table-container {
            background: white;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.02);
            border: 1px solid #f1f5f9;
        }

        .user-avatar {
            width: 42px; height: 42px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
        }
        .status-dipinjam { background: #e0e7ff; color: #4361ee; }
        .status-kembali { background: #f1f5f9; color: #64748b; }
        .status-telat { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }

        .btn-modern {
            border-radius: 12px;
            padding: 8px 18px;
            font-weight: 700;
            font-size: 0.8rem;
            transition: 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-selesai { background: #dcfce7; color: #15803d; }
        .btn-selesai:hover { background: #15803d !important; color: white !important; }

        .btn-delete { background: #fff5f5; color: var(--danger); border: 1px solid #fee2e2; }
        .btn-delete:hover { background: var(--danger); color: white; }

        .fw-800 { font-weight: 800; }
        .fw-700 { font-weight: 700; }
        .fw-600 { font-weight: 600; }
        .delay-info { font-size: 0.7rem; font-weight: 800; display: block; margin-top: 4px; }
        .text-primary { color: var(--primary) !important; }
        
        .pulse-danger {
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <span class="fw-bold fs-5 text-white">Treasure<span style="color:var(--accent)">Library</span></span>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-grip"></i> Dashboard</a>
        <a href="{{ route('admin.user.index') }}"><i class="fa-solid fa-users"></i> Data Anggota</a>
        <a href="{{ route('admin.buku.index') }}"><i class="fa-solid fa-book-open"></i> Koleksi Buku</a>
        <a href="{{ route('admin.scan') }}"><i class="fa-solid fa-qrcode"></i> Scan Peminjaman</a>
        <a href="#" class="active"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pinjam</a>
    </div>

    <div style="position: absolute; bottom: 30px; width: 100%; padding: 0 15px;">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" class="btn btn-outline-danger w-100 btn-modern justify-content-center" onclick="confirmLogout()">
                <i class="fa-solid fa-power-off me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="row align-items-center mb-5">
        <div class="col-lg-4">
            <h2 class="fw-800 mb-1" style="letter-spacing: -1.5px;">Log Transaksi</h2>
            <p class="text-muted small mb-0">Total {{ count($peminjamans) }} aktivitas sirkulasi.</p>
        </div>
        
        <div class="col-lg-8">
            <div class="d-flex gap-3 justify-content-lg-end mt-3 mt-lg-0">
                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari peminjam atau judul buku...">
                </div>

                <a href="{{ route('admin.scan') }}" class="btn btn-add-large">
                    <i class="fa-solid fa-plus fs-5"></i>
                    <span>Tambah Transaksi</span>
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
                        <th class="text-center">STATUS SAAT INI</th>
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
                                <img src="https://ui-avatars.com/api/?background=4361ee&color=fff&name={{ urlencode($p->user->name) }}" class="user-avatar me-3">
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
                                <span class="delay-info text-danger"><i class="fa-solid fa-clock"></i> {{ $durasiTelat }}</span>
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
</div>

<script>
    // FITUR SEARCH JAVASCRIPT
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

    // Alert Verifikasi & Logout Tetap Sama (SweetAlert2)
    function confirmReturn(id, judul) {
        Swal.fire({
            title: 'Verifikasi Buku',
            text: "Konfirmasi bahwa buku '" + judul + "' sudah diterima secara fisik?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Ya, Sudah Kembali',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById('return-form-' + id).submit();
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Riwayat?',
            text: "Data transaksi akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Hapus Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmLogout() {
        Swal.fire({
            title: 'Keluar Admin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
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