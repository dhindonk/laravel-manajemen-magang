<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratSelesai extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'file_surat',
        'tanggal_surat',
        'keterangan'
    ];

    protected $dates = ['tanggal_surat'];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
