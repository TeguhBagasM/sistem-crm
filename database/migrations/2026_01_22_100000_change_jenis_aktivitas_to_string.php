<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_aktivitas', function (Blueprint $table) {
            $table->string('jenis_aktivitas')->change();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_aktivitas', function (Blueprint $table) {
            $table->enum('jenis_aktivitas', ['email', 'followup', 'konten'])->change();
        });
    }
};
