<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAktivitas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_aktivitas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'jenis_aktivitas',
        'tanggal_jadwal',
        'status_aktivitas',
        'id_pelanggan',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_jadwal' => 'date',
    ];

    // Relasi
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    // Scope
    public function scopeDirencanakan($query)
    {
        return $query->where('status_aktivitas', 'direncanakan');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_aktivitas', 'selesai');
    }

    public function scopeEmail($query)
    {
        return $query->where('jenis_aktivitas', 'email');
    }

    public function scopeFollowup($query)
    {
        return $query->where('jenis_aktivitas', 'followup');
    }

    public function scopeKonten($query)
    {
        return $query->where('jenis_aktivitas', 'konten');
    }

    // Helper
    public function getStatusBadgeClass()
    {
        return $this->status_aktivitas === 'selesai' ? 'badge-success' : 'badge-warning';
    }

    public function getJenisBadgeClass()
    {
        return match($this->jenis_aktivitas) {
            'email' => 'badge-primary',
            'followup' => 'badge-info',
            'konten' => 'badge-success',
            default => 'badge-secondary',
        };
    }
}
