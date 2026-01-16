<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatEmail extends Model
{
    use HasFactory;

    protected $table = 'riwayat_email';

    protected $fillable = [
        'id_pelanggan',
        'subjek',
        'isi_pesan',
        'dikirim_oleh',
        'waktu_kirim',
        'status_kirim',
        'waktu_terkirim',
        'error_message',
    ];

    protected $casts = [
        'waktu_kirim' => 'datetime',
    ];

    // Relasi
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'dikirim_oleh');
    }
}
