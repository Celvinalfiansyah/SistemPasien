<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKontrol extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kontrol';

    protected $fillable = [
        'id_pasien',
        'tanggal_kontrol',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_kontrol' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
}
