<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function calonPelanggan()
    {
        return $this->hasMany(CalonPelanggan::class, 'dibuat_oleh');
    }

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'pemilik_data');
    }

    public function riwayatEmail()
    {
        return $this->hasMany(RiwayatEmail::class, 'dikirim_oleh');
    }

    public function jadwalAktivitas()
    {
        return $this->hasMany(JadwalAktivitas::class, 'dibuat_oleh');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMarketing1()
    {
        return $this->role === 'marketing1';
    }

    public function isMarketing2()
    {
        return $this->role === 'marketing2';
    }

    public function isMarketing3()
    {
        return $this->role === 'marketing3';
    }

    public function isMarketing4()
    {
        return $this->role === 'marketing4';
    }

    public function hasAccess($roles)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($this->role, (array) $roles);
    }
}
