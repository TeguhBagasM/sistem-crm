<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            if (!Schema::hasColumn('pelanggan', 'kategori_pelanggan')) {
                $table->string('kategori_pelanggan')->default('retail')->after('status_pelanggan')->nullable();
            }

            if (!Schema::hasColumn('pelanggan', 'rating_pelanggan')) {
                $table->enum('rating_pelanggan', ['VIP', 'High', 'Medium', 'Low'])
                      ->default('Medium')
                      ->after('kategori_pelanggan');
            }

            if (!Schema::hasColumn('pelanggan', 'website')) {
                $table->string('website')->nullable()->after('perusahaan');
            }

            if (!Schema::hasColumn('pelanggan', 'catatan_internal')) {
                $table->text('catatan_internal')->nullable()->after('alamat');
            }

            if (!Schema::hasColumn('pelanggan', 'kontak_terakhir')) {
                $table->dateTime('kontak_terakhir')->nullable()->after('catatan_internal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn([
                'kategori_pelanggan',
                'rating_pelanggan',
                'website',
                'catatan_internal',
                'kontak_terakhir',
            ]);
        });
    }
};
