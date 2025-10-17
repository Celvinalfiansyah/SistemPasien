<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisBayiAnak extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis_bayi_anak';
    protected $fillable = [
        'pasien_id',
        'tanggal_pemeriksaan',
        'umur',
        'berat_badan',
        'keluhan',
        'tindakan'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
