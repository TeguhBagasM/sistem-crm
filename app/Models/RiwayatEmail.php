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
        'waktu_terkirim' => 'datetime',
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

    // Helper Methods
    public function getStatusBadgeClass()
    {
        return match($this->status_kirim) {
            'sent' => 'bg-success',
            'draft' => 'bg-warning',
            'failed' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    public function getStatusLabel()
    {
        return match($this->status_kirim) {
            'sent' => 'Terkirim ✓',
            'draft' => 'Draft (Belum Dikirim)',
            'failed' => 'Gagal Dikirim ✗',
            default => 'Unknown'
        };
    }
}
