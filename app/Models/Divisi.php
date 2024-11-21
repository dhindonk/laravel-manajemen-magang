<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $fillable = ['nama_divisi', 'deskripsi'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function adminDivisi()
    {
        return $this->hasMany(User::class)->role('admin_divisi');
    }
} 