<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_email', function (Blueprint $table) {
            $table->foreignId('id_calon_pelanggan')->nullable()->constrained('calon_pelanggan')->onDelete('cascade')->after('id_pelanggan');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_email', function (Blueprint $table) {
            $table->dropForeignIdFor('CalonPelanggan')->dropColumn('id_calon_pelanggan');
        });
    }
};
