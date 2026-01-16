<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_email', function (Blueprint $table) {
            $table->enum('status_kirim', ['draft', 'sent', 'failed'])->default('draft')->after('waktu_kirim');
            $table->dateTime('waktu_terkirim')->nullable()->after('status_kirim');
            $table->text('error_message')->nullable()->after('waktu_terkirim');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_email', function (Blueprint $table) {
            $table->dropColumn(['status_kirim', 'waktu_terkirim', 'error_message']);
        });
    }
};
