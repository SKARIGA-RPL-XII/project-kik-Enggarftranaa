<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Jika nama tabel Anda di database adalah 'categories'
    protected $table = 'categories'; 

    // Kolom yang boleh diisi secara massal
    protected $fillable = ['nama'];

    // Relasi ke Buku (Satu kategori punya banyak buku)
    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}