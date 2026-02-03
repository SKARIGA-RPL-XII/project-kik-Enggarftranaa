<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Loan Ticket | Treasure International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0f172a;
            --accent-blue: #3b82f6;
            --soft-blue: #f1f5f9;
        }

        body { 
            background: #e2e8f0; 
            padding: 50px 20px;
            font-family: 'Inter', sans-serif;
        }

        /* Container Tiket Utama */
        .ticket-card { 
            background: white; 
            border-radius: 24px; 
            max-width: 420px; 
            margin: auto; 
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.15);
            overflow: hidden;
        }

        /* Header Tiket */
        .ticket-header {
            background: var(--primary-dark);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .ticket-header h5 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .ticket-header p {
            font-size: 0.8rem;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        /* Body Tiket */
        .ticket-body {
            padding: 30px;
            position: relative;
        }

        /* Efek Lubang Tiket (Perforation) */
        .ticket-body::before, .ticket-body::after {
            content: "";
            position: absolute;
            top: -15px;
            width: 30px;
            height: 30px;
            background: #e2e8f0; /* Samakan dengan warna background body */
            border-radius: 50%;
            z-index: 2;
        }
        .ticket-body::before { left: -15px; }
        .ticket-body::after { right: -15px; }

        .qr-wrapper {
            background: var(--soft-blue);
            padding: 25px;
            border-radius: 20px;
            margin: 10px 0 25px 0;
            border: 1px solid rgba(0,0,0,0.05);
            display: inline-block;
            width: 100%;
        }

        .qr-wrapper img {
            max-width: 200px;
            mix-blend-mode: multiply; /* Agar background QR menyatu */
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            display: block;
            margin-bottom: 20px;
        }

        .divider {
            border-top: 2px dashed #e2e8f0;
            margin: 20px 0;
        }

        /* Buttons */
        .btn-print {
            background: var(--primary-dark);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-print:hover {
            background: var(--accent-blue);
            color: white;
            transform: translateY(-2px);
        }

        @media print {
            .btn-print, .btn-back { display: none; }
            body { background: white; padding: 0; }
            .ticket-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>

    <div class="ticket-card">
        <div class="ticket-header">
            <p>E-Library Access</p>
            <h5>Digital Loan Ticket</h5>
        </div>

        <div class="ticket-body">
            <div class="text-center">
                <div class="qr-wrapper">
                    <img src="{{ $qrUrl }}" alt="QR Code">
                    <div class="mt-2">
                        <small class="text-muted" style="font-size: 10px;">ID: TIS-{{ time() }}</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <span class="info-label">Peminjam</span>
                    <span class="info-value">{{ Auth::user()->name }}</span>
                </div>
                <div class="col-6 text-end">
                    <span class="info-label">Tanggal</span>
                    <span class="info-value">{{ date('d M Y') }}</span>
                </div>
            </div>

            <div class="divider"></div>

            <div class="mb-4">
                <span class="info-label">Judul Koleksi</span>
                <span class="info-value" style="color: var(--accent-blue);">{{ $buku->judul }}</span>
            </div>

            <div class="d-grid gap-2">
                <button onclick="window.print()" class="btn btn-print">
                    Download Digital Pass
                </button>
                <a href="/user/buku" class="btn btn-link btn-sm text-decoration-none text-muted btn-back">
                    &larr; Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>

    <p class="text-center mt-4 text-muted small" style="letter-spacing: 1px;">
        &copy; 2026 TREASURE INTERNATIONAL SCHOOL
    </p>

</body>
</html>