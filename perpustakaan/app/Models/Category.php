<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; 

    protected $fillable = ['nama', 'slug']; // Tambahkan slug jika Anda menggunakannya

    // Ubah dari 'bukus' menjadi 'buku' agar sesuai dengan panggilan di Controller
    public function buku()
    {
        // Pastikan kolom di tabel buku adalah 'category_id'
        return $this->hasMany(Buku::class, 'category_id');

    return $this->belongsTo(Category::class, 'category_id');
}
    }
