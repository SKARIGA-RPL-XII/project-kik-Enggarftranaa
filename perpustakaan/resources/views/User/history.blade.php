<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Membaca | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --bg-body: #f8fafc;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
        }

        /* Navbar Styling */
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8) !important;
        }
        .navbar-brand { 
            font-family: 'Playfair Display', serif; 
            font-weight: 900; 
            font-size: 1.5rem; 
            letter-spacing: -0.5px;
        }

        /* History Card */
        .history-card { 
            background: white; 
            border-radius: 20px; 
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 40px rgba(0,0,0,0.03); 
            overflow: hidden;
        }

        /* Table Styling */
        .table thead th { 
            background-color: #f1f5f9;
            color: #475569; 
            font-size: 0.7rem; 
            text-transform: uppercase; 
            letter-spacing: 1.2px; 
            padding: 18px 25px;
            border: none;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table tbody td { 
            padding: 20px 25px; 
            vertical-align: middle; 
            border-bottom: 1px solid #f1f5f9;
        }

        /* Book Info */
        .book-thumb { 
            width: 56px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: 10px; 
            box-shadow: 0 8px 15px rgba(0,0,0,0.1); 
            transition: transform 0.3s ease;
        }
        
        tr:hover .book-thumb {
            transform: scale(1.05);
        }

        /* Custom Badges */
        .badge-status { 
            border-radius: 8px; 
            padding: 8px 14px; 
            font-weight: 700; 
            font-size: 0.7rem; 
            letter-spacing: 0.3px;
        }
        
        .bg-pending { background-color: #fff7ed; color: #c2410c; }
        .bg-active { background-color: #eff6ff; color: #1d4ed8; }
        .bg-success-soft { background-color: #f0fdf4; color: #15803d; }
        .bg-danger-soft { background-color: #fef2f2; color: #b91c1c; }

        /* Typography */
        .heading-title {
            font-weight: 800;
            letter-spacing: -1.5px;
            background: linear-gradient(90deg, #0f172a, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light sticky-top border-bottom py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-dark" href="{{ route('user.dashboard') }}">
            Treasure <span class="text-primary">Library.</span>
        </a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold btn-sm">
            <i class="fas fa-chevron-left me-2"></i> Dashboard
        </a>
    </div>
</nav>

<div class="container py-5">
    <div class="row mb-5 align-items-end">
        <div class="col-md-8">
            <h1 class="heading-title display-5 mb-2">Riwayat Membaca</h1>
            <p class="text-muted fs-5 mb-0">Lacak perjalanan literasi dan manajemen peminjaman buku Anda.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                <i class="fas fa-book text-primary me-2"></i> {{ $peminjamans->count() }} Total Aktivitas
            </span>
        </div>
    </div>

    <div class="history-card">
        @if($peminjamans->isEmpty())
            <div class="text-center py-5 my-4">
                <div class="mb-4">
                    <span class="fa-stack fa-3x">
                        <i class="fas fa-circle fa-stack-2x text-light"></i>
                        <i class="fas fa-book-open fa-stack-1x text-muted"></i>
                    </span>
                </div>
                <h4 class="fw-bold">Belum Ada Catatan</h4>
                <p class="text-muted mx-auto" style="max-width: 300px;">
                    Sepertinya Anda belum meminjam buku. Mari jelajahi koleksi kami!
                </p>
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary rounded-pill mt-2">Cari Buku</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Informasi Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $p)
                        @php
                            $status = strtoupper($p->status);
                            $tgl_kembali = \Carbon\Carbon::parse($p->tgl_kembali);
                            $isOverdue = \Carbon\Carbon::now()->gt($tgl_kembali);
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $p->buku?->cover ? asset('storage/' . $p->buku->cover) : 'https://via.placeholder.com/100x150' }}" 
                                         class="book-thumb" alt="Cover">
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $p->buku?->judul ?? 'Buku Tidak Ditemukan' }}</div>
                                        <div class="small text-muted">{{ $p->buku?->penulis ?? 'Anonim' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-600 small">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>
                                <div class="fw-600 small {{ $isOverdue && ($status != 'KEMBALI' && $status != 'DIKEMBALIKAN') ? 'text-danger' : '' }}">
                                    {{ $tgl_kembali->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td>
                                @if($status == 'AKTIF' || $status == 'DIPINJAM')
                                    @if($isOverdue)
                                        <span class="badge badge-status bg-danger-soft text-danger">
                                            <i class="fas fa-clock me-1"></i> TERLAMBAT
                                        </span>
                                    @else
                                        <span class="badge badge-status bg-active text-primary">
                                            <i class="fas fa-book-reader me-1"></i> DIPINJAM
                                        </span>
                                    @endif
                                @elseif($status == 'KEMBALI' || $status == 'DIKEMBALIKAN')
                                    <span class="badge badge-status bg-success-soft text-success">
                                        <i class="fas fa-check-circle me-1"></i> SELESAI
                                    </span>
                                @else
                                    <span class="badge badge-status bg-light text-secondary">
                                        {{ $status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    
    <div class="mt-4 text-center">
        <p class="small text-muted">
            <i class="fas fa-info-circle me-1"></i> Harap kembalikan buku tepat waktu untuk menghindari denda.
        </p>
    </div>
</div>

</body>
</html>