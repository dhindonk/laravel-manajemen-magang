<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'no_tlpn',
        'asal_kampus',
        'surat_kampus',
        'surat_bakesbangpol',
        'is_verified',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
    ];

    public function suratBalasan()
    {
        return $this->hasOne(SuratBalasan::class);
    }

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}
