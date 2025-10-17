<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisRawatJalan extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis_rawat_jalan';

    protected $fillable = [
        'pasien_id',
        'tanggal_pemeriksaan',
        'ttv',
        'anamnesa',
        'tindakan',
    ];

    protected $dates = ['tanggal_pemeriksaan'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
