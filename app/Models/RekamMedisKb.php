<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisKb extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis_kb';
    protected $fillable = [
        'pasien_id',
        'tanggal_datang',
        'hpht',
        'berat_badan',
        'tensi',
        'komplikasi',
        'kegagalan',
        'pemeriksaan_dan_tindakan',
        'tanggal_kembali'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
