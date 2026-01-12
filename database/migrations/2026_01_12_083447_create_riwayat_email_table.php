<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_email', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelanggan')->constrained('pelanggan')->onDelete('cascade');
            $table->string('subjek');
            $table->text('isi_pesan');
            $table->foreignId('dikirim_oleh')->constrained('users')->onDelete('cascade');
            $table->dateTime('waktu_kirim');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_email');
    }
};
