<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QRController extends Controller {
    public function generateTicket($id) {
        // 1. Ambil data buku
        $buku = Buku::findOrFail($id);

        // 2. Siapkan data teks untuk isi QR (ID User + ID Buku + Waktu)
        $data = "USER:" . Auth::id() . "|BUKU:" . $buku->id . "|TIME:" . now()->timestamp;

        // 3. Buat URL API untuk gambar QR
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($data);

        // 4. Kirim ke halaman tiket
        return view('user.generate-qr', compact('buku', 'qrUrl'));
    }
}