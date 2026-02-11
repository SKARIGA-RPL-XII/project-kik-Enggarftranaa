<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Loan Ticket | TIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-dark: #0f172a; --accent-blue: #3b82f6; }
        body { background: #e2e8f0; padding: 50px 20px; font-family: 'Inter', sans-serif; }
        .ticket-card { background: white; border-radius: 24px; max-width: 400px; margin: auto; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .ticket-header { background: var(--primary-dark); color: white; padding: 25px; text-align: center; }
        .ticket-body { padding: 30px; position: relative; }
        .ticket-body::before, .ticket-body::after { content: ""; position: absolute; top: -15px; width: 30px; height: 30px; background: #e2e8f0; border-radius: 50%; }
        .ticket-body::before { left: -15px; } .ticket-body::after { right: -15px; }
        .qr-wrapper { background: #f1f5f9; padding: 20px; border-radius: 20px; margin-bottom: 25px; text-align: center; }
        .qr-wrapper img { width: 100%; max-width: 200px; mix-blend-mode: multiply; }
        .info-label { font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; }
        .info-value { font-size: 1rem; font-weight: 600; color: var(--primary-dark); display: block; margin-bottom: 15px; }
        .divider { border-top: 2px dashed #e2e8f0; margin: 15px 0; }
        .btn-print { background: var(--primary-dark); color: white; border-radius: 12px; padding: 12px; font-weight: 600; width: 100%; border: none; }
    </style>
</head>
<body>

<div class="ticket-card">
    <div class="ticket-header">
        <p class="small mb-1 opacity-50 text-uppercase">Treasure School E-Library</p>
        <h5 class="mb-0" style="font-family: 'Playfair Display';">Digital Loan Ticket</h5>
    </div>

    <div class="ticket-body">
        <div class="qr-wrapper">
            <img src="{{ $qrUrl }}" alt="QR Code">
            <p class="mt-2 mb-0 text-muted" style="font-size: 10px;">ID: TIS-{{ time() }}</p>
        </div>

        <div class="row">
            <div class="col-6">
                <span class="info-label">Peminjam</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>
            <div class="col-6 text-end">
                <span class="info-label">Batas Kembali</span>
                <span class="info-value text-primary">{{ \Carbon\Carbon::parse($tgl_kembali)->format('d M Y') }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <div class="mb-4">
            <span class="info-label">Koleksi Buku</span>
            <span class="info-value mb-0">{{ $buku->judul }}</span>
        </div>

        <button onclick="window.print()" class="btn btn-print mb-2">Print Ticket</button>
        <a href="{{ route('user.dashboard') }}" class="btn btn-link btn-sm w-100 text-decoration-none text-muted">Back to Catalog</a>
    </div>
</div>

<<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function startPolling() {
        const bukuId = "{{ $buku->id }}";
        const url = "{{ route('user.cek.status', ':id') }}".replace(':id', bukuId);

        console.log("Memulai polling ke: " + url);

        const interval = setInterval(() => {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Cek di Console F12, pastikan muncul: {approved: true} saat admin sudah klik
                    console.log("Respon server:", data); 

                    if (data.approved === true) {
                        clearInterval(interval);
                        
                        // Alert sederhana untuk tes jika SweetAlert gagal
                        console.log("Alert dipicu!"); 

                        Swal.fire({
                            title: 'Berhasil Dipinjam!',
                            text: 'Selamat membaca! Jangan lupa dikembalikan yaa 😊',
                            icon: 'success',
                            confirmButtonColor: '#0f172a',
                            confirmButtonText: 'Ke Dashboard',
                            allowOutsideClick: false
                        }).then((result) => {
                            window.location.href = "{{ route('user.dashboard') }}";
                        });
                    }
                })
                .catch(err => console.error("Polling Error:", err));
        }, 3000); // Cek tiap 3 detik
    }

    // Pastikan fungsi dipanggil
    window.onload = startPolling;
</script>

</body>
</html>