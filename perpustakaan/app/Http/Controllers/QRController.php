<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QRController extends Controller
{
    public function generateTicket(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $user = Auth::user();
        $tgl_kembali = $request->input('tgl_kembali');

        if (!$tgl_kembali) {
            return redirect()->route('user.buku')->with('error', 'Silakan pilih tanggal pengembalian.');
        }

        // FORMAT: USER_ID:1|BUKU_ID:5|KEMBALI:2026-02-15
        $dataQR = "USER_ID:" . $user->id . "|BUKU_ID:" . $buku->id . "|KEMBALI:" . $tgl_kembali;
        
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($dataQR);

        return view('user.generate-qr', compact('buku', 'qrUrl', 'tgl_kembali', 'user'));
    }
}