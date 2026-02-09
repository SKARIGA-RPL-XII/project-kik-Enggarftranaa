<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // Pastikan sesuai nama tabel Anda

    protected $fillable = [
        'user_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status'
    ];

    // Tambahkan ini agar Laravel menghormati format tanggal
    protected $casts = [
        'tgl_pinjam' => 'datetime',
        'tgl_kembali' => 'date', // Ini akan memastikan format YYYY-MM-DD terjaga
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function buku() {
        return $this->belongsTo(Buku::class);
    }
}