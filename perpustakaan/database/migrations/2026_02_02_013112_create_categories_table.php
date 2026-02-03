<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Ini akan menjadi primary key (Big Integer Unsigned)
            $table->string('nama')->unique(); // Nama kategori (Fiksi, Sains, dll)
            $table->string('slug')->unique()->nullable(); // Untuk URL yang rapi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};