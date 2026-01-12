<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'id_calon_pelanggan',
        'nama',
        'email',
        'no_telepon',
        'perusahaan',
        'status_pelanggan',
        'pemilik_data',
    ];

    // Relasi
    public function calonPelanggan()
    {
        return $this->belongsTo(CalonPelanggan::class, 'id_calon_pelanggan');
    }

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_data');
    }

    public function riwayatEmail()
    {
        return $this->hasMany(RiwayatEmail::class, 'id_pelanggan');
    }

    public function jadwalAktivitas()
    {
        return $this->hasMany(JadwalAktivitas::class, 'id_pelanggan');
    }

    // Scope
    public function scopeAktif($query)
    {
        return $query->where('status_pelanggan', 'aktif');
    }

    public function scopeTidakAktif($query)
    {
        return $query->where('status_pelanggan', 'tidak_aktif');
    }

    // Helper
    public function getStatusBadgeClass()
    {
        return $this->status_pelanggan === 'aktif' ? 'badge-success' : 'badge-secondary';
    }
}
