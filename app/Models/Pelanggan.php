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
        'website',
        'alamat',
        'catatan_internal',
        'status_pelanggan',
        'kategori_pelanggan',
        'rating_pelanggan',
        'sumber_pelanggan',
        'kontak_terakhir',
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

    protected $casts = [
        'kontak_terakhir' => 'datetime',
    ];

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

    public function getRatingBadgeClass()
    {
        return match($this->rating_pelanggan) {
            'VIP' => 'bg-danger',
            'High' => 'bg-warning',
            'Medium' => 'bg-info',
            'Low' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    public function getWhatsAppLink()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->no_telepon);
        // Convert to international format if needed
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return "https://wa.me/{$phone}";
    }

    public function getCallLink()
    {
        return "tel:" . $this->no_telepon;
    }

    public function getEmailLink()
    {
        return $this->email ? "mailto:" . $this->email : null;
    }
}
