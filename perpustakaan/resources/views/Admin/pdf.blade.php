<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Perpustakaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .status { font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Riwayat Peminjaman</div>
        <div>Sistem Informasi Treasure Library</div>
    </div>

    <p>Periode: <strong>{{ request('start_date') }}</strong> s/d <strong>{{ request('end_date') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Anggota</th>
                <th width="30%">Judul Buku</th>
                <th width="15%">Tgl Pinjam</th>
                <th width="15%">Tgl Kembali</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $key => $p)
            <tr>
                <td style="text-align: center;">{{ $key + 1 }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->buku->judul }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                <td style="text-align: center;">
                    <span class="status">{{ $p->status }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>