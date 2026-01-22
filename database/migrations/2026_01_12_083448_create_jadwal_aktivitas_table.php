<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_aktivitas', ['email', 'followup', 'konten']);
            $table->date('tanggal_jadwal');
            $table->enum('status_aktivitas', ['direncanakan', 'selesai'])->default('direncanakan');
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggan')->onDelete('cascade');
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('jadwal_aktivitas');
        Schema::enableForeignKeyConstraints();
    }
};
