<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    /**
     * Relasi: Peminjaman ini milik seorang User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Peminjaman ini merujuk pada satu Buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}