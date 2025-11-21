<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'tanggal_pemeriksaan',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'klasifikasi',
        'ttv',
        'hpht',
        'anamnesa',
        'keluhan',
        'komplikasi',
        'kegagalan',
        'tindakan',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
//