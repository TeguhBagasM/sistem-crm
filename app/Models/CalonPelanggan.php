<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPelanggan extends Model
{
    use HasFactory;

    protected $table = 'calon_pelanggan';

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'sumber',
        'alamat',
        'status_lead',
        'catatan',
        'dibuat_oleh',
    ];

    // Relasi
    public function pembuatData()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_calon_pelanggan');
    }

    // Scope
    public function scopeBaru($query)
    {
        return $query->where('status_lead', 'baru');
    }

    public function scopeDihubungi($query)
    {
        return $query->where('status_lead', 'dihubungi');
    }

    public function scopeQualified($query)
    {
        return $query->where('status_lead', 'qualified');
    }

    public function scopeDikonversi($query)
    {
        return $query->where('status_lead', 'dikonversi');
    }

    public function scopeGagal($query)
    {
        return $query->where('status_lead', 'gagal');
    }

    // Helper
    public function getStatusBadgeClass()
    {
        return match($this->status_lead) {
            'baru' => 'badge-primary',
            'dihubungi' => 'badge-info',
            'qualified' => 'badge-warning',
            'dikonversi' => 'badge-success',
            'gagal' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}
