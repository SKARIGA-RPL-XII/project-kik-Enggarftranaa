<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Mengambil data terbaru di posisi paling atas
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function scan()
    {
        return view('admin.scan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_kembali' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $cek = Peminjaman::where('user_id', $request->user_id)
                             ->where('buku_id', $request->buku_id)
                             ->where('status', 'AKTIF')
                             ->first();
            
            if($cek) return redirect()->back()->with('error', 'Gagal! Anggota masih meminjam buku ini.');

            Peminjaman::create([
                'user_id' => $request->user_id,
                'buku_id' => $request->buku_id,
                'tgl_pinjam' => now(),
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'AKTIF',
            ]);

            DB::table('buku')->where('id', $request->buku_id)->decrement('stok');

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }

    public function kembalikan($id)
    {
        DB::beginTransaction();
        try {
            $p = Peminjaman::findOrFail($id);

            // Cek jika sudah dikembalikan
            if (strtoupper(trim($p->status)) === 'DIKEMBALIKAN') {
                return redirect()->back()->with('error', 'Buku sudah berstatus dikembalikan.');
            }

            // Update Status ke DIKEMBALIKAN (sesuai pengecekan di Blade)
            $p->update(['status' => 'DIKEMBALIKAN']);

            // Kembalikan Stok Buku
            DB::table('buku')->where('id', $p->buku_id)->increment('stok');

            DB::commit();
            return redirect()->back()->with('success', 'Buku berhasil diterima! Status diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pengembalian.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $p = Peminjaman::findOrFail($id);
            // Jika dihapus saat masih AKTIF, kembalikan stok
            if (strtoupper(trim($p->status)) === 'AKTIF') {
                DB::table('buku')->where('id', $p->buku_id)->increment('stok');
            }
            $p->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Riwayat berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }
}