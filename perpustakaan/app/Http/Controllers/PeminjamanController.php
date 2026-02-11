<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function scan()
    {
        return view('admin.scan');
    }

    // Method untuk mengambil data detail anggota & buku saat di-scan (AJAX)
    public function getPeminjam($user_id, $buku_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $buku = Buku::findOrFail($buku_id);

            return response()->json([
                'success' => true,
                'user' => [
                    'id_asli' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'foto' => $user->foto_url ?? '', // Sesuaikan field foto Anda
                ],
                'buku' => [
                    'id' => $buku->id,
                    'judul' => $buku->judul,
                    'kode' => $buku->kode_buku ?? $buku->id,
                    'cover_url' => asset('storage/' . $buku->cover), // Sesuaikan path cover
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!']);
        }
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
            // Cek duplikasi peminjaman aktif
            $cek = Peminjaman::where('user_id', $request->user_id)
                             ->where('buku_id', $request->buku_id)
                             ->where('status', 'AKTIF')
                             ->first();
            
            if($cek) return redirect()->back()->with('error', 'Anggota masih meminjam buku ini.');

            // Buat transaksi
            Peminjaman::create([
                'user_id' => $request->user_id,
                'buku_id' => $request->buku_id,
                'tgl_pinjam' => now(),
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'AKTIF',
            ]);

            // Kurangi stok
            DB::table('buku')->where('id', $request->buku_id)->decrement('stok');

            DB::commit();
            
            // REDIRECT KE HALAMAN INDEX (Riwayat)
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function kembalikan($id)
    {
        DB::beginTransaction();
        try {
            $p = Peminjaman::findOrFail($id);
            if (strtoupper($p->status) === 'DIKEMBALIKAN') {
                return redirect()->back()->with('error', 'Buku sudah dikembalikan.');
            }

            $p->update(['status' => 'DIKEMBALIKAN']);
            DB::table('buku')->where('id', $p->buku_id)->increment('stok');

            DB::commit();
            return redirect()->back()->with('success', 'Buku berhasil diterima!');
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
            if (strtoupper($p->status) === 'AKTIF') {
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
  public function userHistory()
{
    $peminjamans = Peminjaman::with('buku')
        ->where('user_id', auth()->id())
        ->orderByRaw("FIELD(status, 'AKTIF', 'DIPINJAM', 'KEMBALI') ASC") // Urutkan yang aktif dulu
        ->orderBy('tgl_pinjam', 'desc')
        ->get();

    return view('user.history', compact('peminjamans'));
}
}