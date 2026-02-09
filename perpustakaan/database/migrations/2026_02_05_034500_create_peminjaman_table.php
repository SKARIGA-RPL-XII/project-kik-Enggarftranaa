<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel buku
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            
            $table->dateTime('tgl_pinjam');
            $table->dateTime('tgl_kembali')->nullable();
            
            // Mengubah string menjadi enum dengan opsi: dipinjam, dikembalikan
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};