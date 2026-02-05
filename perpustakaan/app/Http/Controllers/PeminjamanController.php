<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan halaman scanner
     */
    public function index()
    {
        return view('admin.scan');
    }

    /**
     * AJAX: Mencari data User dan Buku dari Payload QR
     * Format Payload: USER:3|BUKU:1|TIME:123456
     */
    public function checkData($payload)
    {
        try {
            $userId = null;
            $bukuId = null;

            // 1. Bedah Payload
            if (str_contains($payload, '|')) {
                $parts = explode('|', $payload);
                foreach ($parts as $part) {
                    if (str_starts_with($part, 'USER:')) $userId = str_replace('USER:', '', $part);
                    if (str_starts_with($part, 'BUKU:')) $bukuId = str_replace('BUKU:', '', $part);
                }
            } else {
                $userId = $payload; // Fallback jika hanya ID angka
            }

            // 2. Ambil Data User
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Anggota tidak ditemukan!']);
            }

            // 3. Ambil Data Buku (Opsional jika ingin ditampilkan di scan)
            $buku = Buku::find($bukuId);

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'foto' => $user->avatar ? asset('img/avatars/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random',
                ],
                'buku' => $buku ? [
                    'id' => $buku->id,
                    'judul' => $buku->judul
                ] : null
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Eksekusi simpan ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'nullable|exists:bukus,id',
        ]);

        DB::beginTransaction();
        try {
            // Simpan transaksi
            Peminjaman::create([
                'user_id' => $request->user_id,
                'buku_id' => $request->buku_id, // Mengambil ID buku dari hasil bedah QR
                'tgl_pinjam' => now(),
                'status' => 'AKTIF',
            ]);

            // Kurangi stok buku jika ada buku_id
            if ($request->buku_id) {
                Buku::where('id', $request->buku_id)->decrement('stok');
            }

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Peminjaman berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.');
        }
    }
}