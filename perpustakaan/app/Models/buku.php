<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Secara default Laravel akan menganggap nama tabelnya adalah 'bukus'.
     */
    protected $table = 'buku';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * Ini penting agar data dari form Admin bisa langsung disimpan ke database.
     */
    protected $fillable = [
        'category_id',
        'judul',
        'penulis',
        'cover',
        'deskripsi',
        'stok',
    ];

    /**
     * Relasi: Satu buku bisa dipinjam berkali-kali (History Peminjaman).
     */
    public function kategori() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}